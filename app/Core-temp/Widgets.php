<?php
/**
 * Widgets Class
 *
 * This file contains the Widgets class which is responsible for registering and managing
 * custom widgets for the Codehills Kickstarter theme. The class includes methods for defining
 * widget areas, registering custom widgets, and handling their display logic.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

class Widgets {
    /**
     * Instance
     *
     * @since 2.0.0
     * @access private
     * @static
     *
     * @var Theme The single instance of the class.
     */
    private static $instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 2.0.0
     * @access public
     *
     * @return Theme An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     * Class constructor
     *
     * Register theme functions action hooks and filters
     *
     * @since 2.0.0
     * @access public
     */
    public function __construct()
    {
        // Register theme widgets
        add_action( 'widgets_init', array( $this, 'register_widgets' ) );
    }

    /**
     * Register theme widgets
     * 
     * @since 2.0.0
     * @access public
     */
    public function register_widgets()
    { 
        // Main Sidebar
        register_sidebar( array(
            'name'              =>  __( 'Main Sidebar', ThemeFunctions::TEXT_DOMAIN ),
            'id'                =>  'codehills_main_sidebar',
            'description'       =>  __( 'Default sidebar for Codehills Kickstarter theme', ThemeFunctions::TEXT_DOMAIN ),
            'before_widget'     =>  '<div id="%1$s" class="widget cleafix %2$s">',
            'after_widget'      =>  '</div>',
            'before_title'      =>  '<h4>',
            'after_title'       =>  '</h4>'
        ));
    }
}