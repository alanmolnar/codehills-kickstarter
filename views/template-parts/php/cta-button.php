<?php
/**
 * CTA Button Template Part
 *
 * This template part displays a call-to-action (CTA) button. It retrieves the button label,
 * URL, style, additional classes, and attributes from the provided arguments and displays
 * the button accordingly. It also supports opening the link in a new tab.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get CTA button data
$cta_label              = $args['cta_label'];
$cta_url                = $args['cta_url'];
$cta_style              = $args['cta_style'];
$additional_classes     = $args['additional_classes'];
$additional_attributes  = $args['additional_attributes'];
$new_tab                = isset( $args['new_tab'] ) ? $args['new_tab'] : false;

// CTA button
if( $cta_label != '' && $cta_url != '' ) :
    echo '<div>';

    echo '<a href="' . esc_url( $cta_url ) . '" class="uk-button uk-button-' . $cta_style . ' ' . $additional_classes . ' uk-flex uk-flex-middle uk-flex-center" ' . ( $new_tab ? 'rel="noopener noreferrer nofollow" target="_blank"' : '' )  . ' ' . $additional_attributes . '>';

    // Check if button has icon on the left
    if( strpos( $additional_classes, 'uk-button-icon' ) !== false ) :
        echo '<img class="uk-preserve uk-margin-small-right" src="' . get_template_directory_uri() . '/assets/img/icon-instagram.svg" width="24" height="24" alt="Instagram" uk-svg>';
    endif;

    echo '<span>' . $cta_label . '</span>';

    // Check if button have link arrow
    if( strpos( $additional_classes, 'uk-button-link-arrow' ) !== false ) :
        echo '<span class="uk-margin-small-left" uk-icon="icon: chevron-right; ratio: 0.9;"></span>';
    endif;

    echo '</a></div>';
endif;