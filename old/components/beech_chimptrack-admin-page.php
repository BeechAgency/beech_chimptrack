<?php

function BEECH_chimptrack_admin_page() { 
	// jQuery
	wp_enqueue_script('jquery');
	// This will enqueue the Media Uploader script
	wp_enqueue_media();

    // enqueue the plugin css
    wp_enqueue_style( 'BEECH_chimptrack_admin_css', plugins_url( 'assets/admin.css', __FILE__ ) );

    include( plugin_dir_path( __FILE__ ). 'templates/admin-menu.php' );
    //echo '<h1>Chimp trackin!</h1>';
    // enqueue the js
    wp_enqueue_script('BEECH_chimptrack_admin_js', plugins_url( 'assets/admin.js', __FILE__ ), array('jquery') );
}

add_action( 'admin_menu', 'BEECH_chimptrack_admin_menu' );  

/*
	Use the media library
*/
// UPLOAD ENGINE
function BEECH_chimptrack_load_wp_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'BEECH_chimptrack_load_wp_media_files' );
