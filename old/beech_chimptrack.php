<?php
/**
 * Plugin Name: BEECH Chimp Track
 * Plugin URI: https://beech.agency
 * Description: Mailchimp tracking the things!
 * Version: 0.1
 * Author: BEECH Agency
 * Author URI: https://beech.agency
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'BEECH_Updater' ) ){
	//include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

//$updater = new BEECH_Updater( __FILE__ );
//$updater->set_username( 'BeechAgency' );
//$updater->set_repository( 'beech_chimptrack' );
/*
	$updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
//$updater->initialize();

global $BEECH_CHIMPTRACK;
$BEECH_CHIMPTRACK = array();

$BEECH_CHIMPTRACK['settings'] = array(
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

 // Set up settings
if( !function_exists("BEECH_chimptrack_init") ) { 
	function BEECH_chimptrack_init() {   
		/* Sidebar chimptrack Settings */
		if(empty($BEECH_CHIMPTRACK['settings'])) return;

		foreach( $BEECH_CHIMPTRACK['settings'] as $setting ) :

			register_setting( 
				'BEECH-chimptrack-settings', 
				$setting['key'], 
				array(
					'default' => $setting['default'],
					'description' => $setting['description'],
					'type' => $setting['type']
				) 
			);

		/*
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--CONFIG__dc' );
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--CONFIG__audience_id' );
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--CONFIG__apikey' );
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--CONFIG__apiuser' );
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--SETTING__track_pageviews' );
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--SETTING__track_gforms' );
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--SETTING__track_downloads' );
		register_setting( 'BEECH-chimptrack-settings', 'BEECH_chimptrack--SETTING__all_3rd_party' );
		*/

		endforeach;
	}
}

// Set up menu
function BEECH_chimptrack_admin_menu() {
	 $parent_slug = 'tools.php';
	 $page_title = 'Chimp Track';   
	 $menu_title = 'Chimp Track';   
	 $capability = 'manage_options';   
	 $menu_slug  = 'chimptrack';  
	 $function   = 'BEECH_chimptrack_admin_page';   
	 $icon_url   = 'dashicons-bell';   
	 $position   = (int) 10;    

	 add_submenu_page( 
		 $parent_slug,
		 $page_title,                  
		 $menu_title,                   
		 $capability,                   
		 $menu_slug,                   
		 $function,                                 
		 $position 
	); 
	add_action( 'admin_init', 'BEECH_chimptrack_init' ); 
}


require_once('components/beech_chimptrack-admin-page.php');
//require_once('components/beech_chimptrack-side-notification.php');
/*
require 'components/beech_login-login-page.php';
require 'components/beech_login-messages.php';
*/