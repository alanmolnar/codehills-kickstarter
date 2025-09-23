<?php
/**
 * EnqueueFrontend Class
 *
 * This file contains the EnqueueFrontend class which is responsible for managing
 * the enqueueing of styles and scripts for the front-end of the Codehills Kickstarter theme.
 * The class includes methods for registering and enqueueing theme stylesheets and scripts, ensuring
 * that all necessary assets are properly loaded.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

class EnqueueFrontend {
    /**
     * Init
     * 
     * Enqueue theme frontend assets
     *
     * @since 2.0.0
     * @access public
     */
    public function init()
    {
        // Register theme styles
        wp_register_style( 'codehills_kickstarter_google_fonts', '//fonts.googleapis.com/css2?family=Outfit:wght@0,100..900&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap', array(), null );
        wp_register_style( 'codehills_kickstarter_splide_stylesheet', get_template_directory_uri() . '/resources/css/splide-core.min.css' );
        wp_register_style( 'codehills_kickstarter_main_theme_stylesheet', get_template_directory_uri() . '/resources/css/main.css' );

        // Enqueue theme styles
        wp_enqueue_style( 'codehills_kickstarter_google_fonts' );
        wp_enqueue_style( 'codehills_kickstarter_splide_stylesheet' );
        wp_enqueue_style( 'codehills_kickstarter_main_theme_stylesheet' );

        // Smart jQuery inclusion
        if ( !is_admin() ) :
            wp_deregister_script( 'jquery' );
            wp_enqueue_script( 'jquery', get_template_directory_uri() . '/resources/js/jquery-3.7.1.min.js', array(), null, true );
            wp_enqueue_script( 'jquery' );
        endif;

        // Register theme scripts
        wp_register_script( 'codehills_kickstarter_uikit_script', get_template_directory_uri() . '/resources/js/uikit.min.js', array(), false, true );
        wp_register_script( 'codehills_kickstarter_uikit_icons_script', get_template_directory_uri() . '/resources/js/uikit-icons.min.js', array(), false, true );
        wp_register_script( 'codehills_kickstarter_uikit_icons_script', get_template_directory_uri() . '/resources/js/uikit-icons.min.js', array(), false, true );
        wp_register_script( 'codehills_kickstarter_splide_script', get_template_directory_uri() . '/resources/js/splide.min.js', array(), false, true );
        wp_register_script( 'codehills_kickstarter_main_theme_script', get_template_directory_uri() . '/resources/js/main.js', array(), false, true );
        
        // Localize script for using with wp-ajax
        wp_localize_script( 'codehills_kickstarter_main_theme_script', 'theme_ajax_params', array(
            'ajax_url' => site_url() . '/wp-admin/admin-ajax.php'
        ));

        // Enqueue theme scripts
        wp_enqueue_script( 'codehills_kickstarter_uikit_script' );
        wp_enqueue_script( 'codehills_kickstarter_uikit_icons_script' );
        wp_enqueue_script( 'codehills_kickstarter_splide_script' );
        wp_enqueue_script( 'codehills_kickstarter_splide_autoscroll_script' );
        wp_enqueue_script( 'codehills_kickstarter_main_theme_script' );
    }
}