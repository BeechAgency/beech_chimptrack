<?php
    function BEECH_chimptrack_side_notification_init() {
        $is_enabled = get_option( 'BEECH_chimptrack--SIDE_BAR__enabled' );
        $title = get_option( 'BEECH_chimptrack--SIDE_BAR__title' );
        $description = get_option( 'BEECH_chimptrack--SIDE_BAR__description' );
        $link = get_option( 'BEECH_chimptrack--SIDE_BAR__link' );
        $image = get_option( 'BEECH_chimptrack--SIDE_BAR__image' );
        $id = get_option( 'BEECH_chimptrack--SIDE_BAR__id' );
        $days = get_option( 'BEECH_chimptrack--SIDE_BAR__days-dismissed' );

        if(empty($days)) {
            $days = 30;
        }

        if( $is_enabled ) {

            $BEECH_sb_options = array(
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'image' => $image,
                'days' => $days
            );


            wp_enqueue_style( 'BEECH_chimptrack_css', plugins_url( 'assets/beech-chimptrack.css', __FILE__ ) );

            include( plugin_dir_path( __FILE__ ). 'templates/side-notification.php' );

            wp_enqueue_script('BEECH_chimptrack_js', plugins_url( 'assets/beech-chimptrack.js', __FILE__ ) );
        }
    }
    
    add_action( 'wp_footer', 'BEECH_chimptrack_side_notification_init' );