<?php
/**
 * Block Titles Template Part
 *
 * This template part displays the titles for a block. It retrieves the title and subtitle
 * from the block global settings and displays them with the specified HTML tags and styles.
 * This partial can be included in other templates to display block titles.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

if( isset( $args['block_global_settings'] ) && ! empty( $args['block_global_settings'] ) ) :
    // Get block global settings
    $block_global_settings = $args['block_global_settings'];

    // Get titles order
    $order_first = isset( $args['order_first'] ) ? $args['order_first'] : 'title';

    // Get details
    $title                      = $block_global_settings->title;
    $title_tag                  = $block_global_settings->title_tag != null ? $block_global_settings->title_tag : 'h2';
    $title_style                = $block_global_settings->title_style;
    $subtitle                   = $block_global_settings->subtitle;
    $subtitle_tag               = $block_global_settings->subtitle_tag != null ? $block_global_settings->subtitle_tag : 'h4';
    $subtitle_style             = $block_global_settings->subtitle_style;
    $disable_global_title       = isset( $block_global_settings->disable_global_title ) ? $block_global_settings->disable_global_title : false;
    $disable_global_subtitle    = isset( $block_global_settings->disable_global_subtitle ) ? $block_global_settings->disable_global_subtitle : false;
endif;

// Display titles
if( isset( $title ) || isset( $subtitle ) ) :
    echo '<div class="block-titles uk-child-width-1-1" uk-grid>';

    // Title
    if( isset( $title ) && $title != '' && ! $disable_global_title ) :
        echo '<div' . ( $order_first == 'subtitle' ? ' class="uk-flex-last"' : '' ) . '><' . $title_tag . ' class="uk-' . $title_style . '">' . $title . '</' . $title_tag . '></div>';
    endif;

    // Subtitle
    if( isset( $subtitle ) && $subtitle != '' && ! $disable_global_subtitle ) :
        echo '<div><' . $subtitle_tag . ' class="uk-' . $subtitle_style . ' uk-margin-remove-top">' . $subtitle . '</' . $subtitle_tag . '></div>';
    endif;

    echo '</div>';
endif;