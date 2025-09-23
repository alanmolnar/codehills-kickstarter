<?php
/**
 * Title / Conntent Grid Template Part
 *
 * This template part displays the titles for a block in the grid. It retrieves the title and subtitle
 * from the block global settings and displays them with the specified HTML tags and styles.
 * This partial can be included in other templates to display block titles.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Block details
$block_details = isset($args['block_details']) && !empty($args['block_details']) ? (array) $args['block_details'] : [];

// Block global settings
$block_global_settings = !empty($args['block_global_settings']) ? $args['block_global_settings'] : [];

// Grid title content
$title_content =  isset( $args['title_content'] ) && $args['title_content'] != '' ? $args['title_content'] : '';

echo '<div class="uk-flex-between uk-flex-bottom" uk-grid>
    <div class="uk-width-1-' . ( $block_details['content'] != '' || $title_content != '' ? '2' : '1' ) . '@m">';

// Get block titles
get_template_part( 'views/builder/partials/php/block-titles', null, array(
    'block_global_settings' => $block_global_settings
) );

echo '</div>';

// Content
if( $block_details['content'] != '' || ( isset( $title_content ) && $title_content != '' ) ) :
    if( isset( $title_content ) && $title_content != '' ) :
        echo '<div class="uk-width-2-5@m">' . $title_content . '</div>';
    elseif( $block_details['content'] != '' ) :
        echo '<div class="uk-width-2-5@m">' . $block_details['content'] . '</div>';
    endif;
endif;

echo '</div>';