<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/joshwayman
 * @since      1.0.0
 *
 * @package    Beech_chimptrack
 * @subpackage Beech_chimptrack/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Beech_chimptrack
 * @subpackage Beech_chimptrack/admin
 * @author     Beech Agency <hi@beech.agency>
 */
class Beech_chimptrack_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $this->set_settings();

	}

	public function set_settings() {
		return array(
			array(
				'title' => 'Enable Chimptrack',
				'key' => 'BEECH_chimptrack--SETTING__enabled',
				'description' => 'Turn this pup on!',
				'default' => 0,
				'type' => 'boolean',
				'group' => 'Config'
			),
			array(
				'title' => 'Data Center',
				'key' => 'BEECH_chimptrack--CONFIG__dc',
				'description' => 'The data center code, first 3 letter subdomain for your mailchimp URL',
				'default' => '',
				'type' => 'string',
				'group' => 'Config'
			),
			array(
				'title' => 'Audience ID',
				'key' => 'BEECH_chimptrack--CONFIG__audience_id',
				'description' => 'Get this from MailChimp',
				'default' => '',
				'type' => 'string',
				'group' => 'Config'
			),
			array(
				'title' => 'API Key',
				'key' => 'BEECH_chimptrack--CONFIG__apikey',
				'description' => 'Get this from MailChimp',
				'default' => '',
				'type' => 'string',
				'group' => 'Config'
			),
			array(
				'title' => 'API User',
				'key' => 'BEECH_chimptrack--CONFIG__apiuser',
				'description' => 'Get this from MailChimp, optional',
				'default' => '',
				'type' => 'string',
				'group' => 'Config'
			),
			array(
				'title' => 'Track Pageviews',
				'key' => 'BEECH_chimptrack--SETTING__track_pageviews',
				'description' => 'Track page views',
				'default' => 0,
				'type' => 'boolean',
				'group' => 'Settings'
			),
			array(
				'title' => 'Track Gravity Forms',
				'key' => 'BEECH_chimptrack--SETTING__track_gforms',
				'description' => 'If using Gravity forms, track those doggos!',
				'default' => 0,
				'type' => 'boolean',
				'group' => 'Settings'
			),
			array(
				'title' => 'Track Downloads',
				'key' => 'BEECH_chimptrack--SETTING__track_downloads',
				'description' => 'Track downloads',
				'default' => 0,
				'type' => 'boolean',
				'group' => 'Settings'
			),
			array(
				'title' => 'Allow 3rd Party Goodness',
				'key' => 'BEECH_chimptrack--SETTING__all_3rd_party',
				'description' => 'All 3rd party integrations',
				'default' => 0,
				'type' => 'boolean',
				'group' => 'Settings'
			),
		);
	}

	/**
	 * Setup the settings
	 */
	public function register_settings() {
		
		foreach($this->settings as $setting) {
			register_setting( 
				'beech_chimptrack_settings', 
				$setting['key'], 
				array(
					'default' => $setting['default'],
					'description' => $setting['description'],
					'type' => $setting['type']
				) 
			);
		}
		
	}

	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Setup the admin menu
	 */
	public function register_chimptrack_menu() {
		$parent_slug = 'tools.php';
	 	$page_title = 'Chimp Track';   
	 	$menu_title = 'Chimp Track';   
	 	$capability = 'manage_options';   
	 	$menu_slug  = 'beech_chimptrack';  
	 	$function   = 'register_admin_page';   
	 	$position   = (int) 10;    
		/*
		add_options_page(
			'Chimp Track Settings',
			'Chimp Track',
			'manage_options',
			'chimptrack-options',
			array( $this, 'register_admin_display' ),
			null
		);
		*/
		
		add_submenu_page( 
			$parent_slug,
			$page_title,                  
			$menu_title,                   
			$capability,                   
			$menu_slug,                   
			array( $this,  'register_admin_display' ),                                 
			$position 
		);
	}

	/**
	 * Register admin page
	 */
	public function register_admin_display() {
		include_once 'partials/beech_chimptrack-admin-display.php';
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/beech_chimptrack-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/beech_chimptrack-admin.js', array( 'jquery' ), $this->version, false );

	}

}
