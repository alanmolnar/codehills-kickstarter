<?php
/**
 * EnqueueBackend Class
 *
 * This file contains the EnqueueBackend class which is responsible for managing
 * the enqueueing of styles and scripts for the admin backend of the Codehills Kickstarter theme.
 * The class includes methods for registering and enqueueing admin stylesheets and scripts,
 * ensuring that all necessary assets are properly loaded in the WordPress admin area.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

class EnqueueBackend {
    /**
     * Init
     *
     * Enqueue theme backend assets
     *
     * @since 2.0.0
     * @access public
     */
    public function init()
    {
        wp_register_style( 'google-fonts', '//fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap', array(), null );
        wp_enqueue_style( 'google-fonts' );
    }
}