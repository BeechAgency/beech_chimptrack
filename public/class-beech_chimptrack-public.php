<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/joshwayman
 * @since      1.0.0
 *
 * @package    Beech_chimptrack
 * @subpackage Beech_chimptrack/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Beech_chimptrack
 * @subpackage Beech_chimptrack/public
 * @author     Beech Agency <hi@beech.agency>
 */
class Beech_chimptrack_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Beech_chimptrack_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Beech_chimptrack_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/beech_chimptrack-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Beech_chimptrack_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Beech_chimptrack_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/beech_chimptrack-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the ChimpTrack endpoint
	 */
	public function register_api_endpoint() {
		register_rest_route('bct/v1', '/event/', array(
        	'methods' => 'POST',
        	'callback' => array($this, 'handle_endpoint_callback'),
    	));
	}

	/**
	 * Handle Endpoint Callback
	 */
	public function handle_endpoint_callback(WP_REST_Request $request) {
		function data_is_valid($data) {
			if(empty($data['uid'])) return false;
			if(empty($data['event'])) return false;
			if(empty($data['properties'])) return false;

			return true;
		}

		// Retrieve data from the request
		$data = $request->get_params();

		//return new WP_REST_Response($data, 200);
		
		// Process the received data (for demonstration, simply echoing here)
		$str = '';

		if ( data_is_valid($data) ) {
			$uid = $data['uid'];
			$event = $data['event'];
			$properties = $data['properties'];

			$str = $this->make_mailchimp_event_call($uid, $event, $properties);

		} else {
			$str = 'No data received.';
		}

		// You can perform any processing or database operations with the received data here

		// You might want to return a response after processing the data
		return new WP_REST_Response('Data received and processed,'.$str, 200);
	}

	private function handle_contact_id( $uid ) {
		if(empty($uid)) return false;

		$this->start_chimptrack_session();

		if(isset($this->contact_id)) {

			$_SESSION['chimptrack_id'] = $this->contact_id;

			return $this->contact_id;

		} elseif (isset($_SESSION['chimptrack_id'])) {
			$this->contact_id = $_SESSION['chimptrack_id'];
			return $_SESSION['chimptrack_id'];

		} else {
			$contact_id = $this->get_mailchimp_contact_id($uid);

			$_SESSION['chimptrack_id'] = $contact_id;
			$this->contact_id = $contact_id;

			return $contact_id;
		}
	}

	private function get_mailchimp_contact_id( $uid ) {
		$dc =  get_option( 'BEECH_chimptrack--CONFIG__dc' );
		$apiKey =  get_option('BEECH_chimptrack--CONFIG__apikey' );
		$apiUser = get_option('BEECH_chimptrack--CONFIG__apiuser' );
		$audienceId =  get_option('BEECH_chimptrack--CONFIG__audience_id' );
		
		$requestUrl = "https://$dc.api.mailchimp.com/3.0/lists/$audienceId/members?unique_email_id=$uid&fields=members.id,members.full_name,members.contact_id";
		$requestArgs = array(
			'headers' => array(
				'Content-Type' => 'text/plain',
				'Authorization' => 'Basic '.base64_encode($apiUser.':'.$apiKey)
			)
		);
		$response = wp_remote_get($requestUrl, $requestArgs);

		if( ! is_wp_error( $response ) ) {
			$response_body = wp_remote_retrieve_body( $response );

			$data = json_decode($response_body);

			if(count($data->members) > 0) {
				return $data->members[0]->id;
			} else {
				return false;
			}

		} else {
			echo 'Error: ' . $response->get_error_message();
		}
	}

	private function make_mailchimp_event_call($uid, $event, $args = array() ) {

		$dc =  get_option( 'BEECH_chimptrack--CONFIG__dc' );
		$apiKey =  get_option('BEECH_chimptrack--CONFIG__apikey' );
		$apiUser = get_option('BEECH_chimptrack--CONFIG__apiuser' );
		$audienceId =  get_option('BEECH_chimptrack--CONFIG__audience_id' );

		$contactId = $this->handle_contact_id( $uid );

		$request_url = "https://$dc.api.mailchimp.com/3.0/lists/$audienceId/members/$contactId/events";
		$request_args = array(
			'headers' => array(
				'Content-Type' => 'text/plain',
				'Authorization' => 'Basic '.base64_encode($apiUser.':'.$apiKey)
			),
			'body' => json_encode(array(
				"name" => $event,
				"properties" => $args
			))
		);

		$response = wp_remote_post( $request_url, $request_args);

		//return json_encode($request_args);

		if ( ! is_wp_error( $response ) ) {
			$response_code = wp_remote_retrieve_response_code( $response ); // Get the response code
			$response_body = wp_remote_retrieve_body( $response ); // Get the response body

			$body = json_decode($response_body);

			return json_encode($body) .' '. json_encode($request_args);
		} else {
			return 'Error: ' . $response->get_error_message() ;
		}
	}


	// Add your session-related code within a function
	public function start_chimptrack_session() {
		if (!session_id()) {
			session_start();
		}
	}
}
