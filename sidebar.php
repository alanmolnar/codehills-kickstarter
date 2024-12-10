<?php
/**
 * Codehills Kickstarter Default Sidebar Template
 *
 * This template is used to display the default sidebar in the Codehills Kickstarter theme.
 * It checks if the 'codehills_main_sidebar' is active and displays its widgets.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Main sidebars
if( is_active_sidebar( 'codehills_main_sidebar' ) ) :
    dynamic_sidebar( 'codehills_main_sidebar' );
endif;