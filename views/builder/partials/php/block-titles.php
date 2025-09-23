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

    // Get block titles
    $block_titles = ! empty( $block_global_settings->block_titles ) ? $block_global_settings->block_titles : null;
endif;

// Display titles
if ( $block_titles != null ) :
    echo '<div class="block-titles uk-child-width-1-1 uk-grid-small" uk-grid>';
    
    foreach ( $block_titles as $block_title ) :
        // Set title tag
        $title_tag = ! empty( $block_title['title_tag'] ) ? $block_title['title_tag'] : 'h2';

        // Set title align
        $title_align = ! empty( $block_title['title_align'] ) && $block_title['title_align'] !== 'left' ? 'uk-text-' . esc_attr( $block_title['title_align'] ) : '';

        // Convert title margins value 'normal' to UI Kit default 'uk-margin'
        $title_top_margin       = $block_title['title_top_margin'] === 'normal' ? 'uk-margin-top' : 'uk-margin-' . esc_attr( $block_title['title_top_margin'] ) . '-top';
        $title_bottom_margin    = $block_title['title_bottom_margin'] === 'normal' ? 'uk-margin-bottom' : 'uk-margin-' . esc_attr( $block_title['title_bottom_margin'] ) . '-bottom';

        // Remove title margins if user selects 'none'
        $title_top_margin     = $block_title['title_top_margin'] === 'none' ? 'uk-margin-remove-top' : $title_top_margin;
        $title_bottom_margin  = $block_title['title_bottom_margin'] === 'none' ? 'uk-margin-remove-bottom' : $title_bottom_margin;

        // Set title margins custom values
        $title_top_margin_custom    = isset( $block_title['title_top_margin_custom'] ) &&  $block_title['title_top_margin'] === 'custom' ? 'margin-top: ' . esc_attr( $block_title['title_top_margin_custom'] ) . 'px;' : '';
        $title_bottom_margin_custom = isset( $block_title['title_bottom_margin_custom'] ) && $block_title['title_bottom_margin'] === 'custom' ? 'margin-bottom: ' . esc_attr( $block_title['title_bottom_margin_custom'] ) . 'px;' : '';

        // Title
        echo '<' . esc_html( $title_tag ) . ' class="uk-' . esc_attr( $block_title['title_style'] ) . ' uk-width-' . esc_attr( $block_title['title_width'] ) . '@m ' . esc_attr( $title_align ) . ' ' . esc_attr( $title_top_margin ) . ' ' . esc_attr( $title_bottom_margin ) . '" style="' . esc_attr( $title_top_margin_custom ) . ' ' . esc_attr( $title_bottom_margin_custom ) . '">
            ' . ( ! empty( $block_title['title'] ) ? $block_title['title'] : '' ) . '
        </' . esc_html( $title_tag ) . '>';
    endforeach;

    echo '</div>';
endif;