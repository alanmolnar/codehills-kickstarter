<?php
/**
 * Site Logo Template Part
 *
 * This template displays the site logo. It checks if a custom logo is set via theme options
 * and displays it. If no custom logo is set, it displays the default theme logo.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Site logo
if( class_exists( 'ACF' ) && function_exists( 'get_field' ) && get_field( 'logo', 'option' ) ) :
    // Site logo uploaded via theme options
    echo '<a class="uk-navbar-item uk-logo" href="' . esc_url( site_url() ) . '">
        <img class="uk-preserve" src="' . get_field( 'logo', 'option' ) . '" width="165" height="40" alt="' . get_bloginfo( 'name' ) . '" uk-svg>
    </a>';
else :
    // Default theme logo
    echo '<a href="' . esc_url( site_url() ) . '/wp-admin/admin.php?page=codehills-kickastarter-settings">
        <img class="uk-preserve uk-margin-top uk-margin-bottom" src="' . get_template_directory_uri() . '/resources/img/theme/default-logo.svg" width="180" height="70" alt="Codehills Kickstarter" uk-svg>
    </a>';
endif;