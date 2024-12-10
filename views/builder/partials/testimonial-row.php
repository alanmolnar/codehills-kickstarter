<?php
/**
 * Testimonial Row Template Part
 *
 * This template part displays a single testimonial row. It includes the testimonial name, position,
 * image and quote. This partial can be included in other templates to display individual
 * testimonial items.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

if( ! defined( 'WPINC' ) ) :
    die;
endif;

// Get details
$testimonial = $args['testimonial'];

echo '<div>';

// Content
if( isset( $testimonial['content'] ) && $testimonial['content'] != '' ) :
    echo '<div class="customer-testimonial-content uk-margin-bottom">' . $testimonial['content'] . '</div>';
endif;

echo '<div class="uk-grid-small" uk-grid>';

// Image
if( isset( $testimonial['image'] ) ) :
    echo '<div class="uk-width-auto">
        <img class="transition uk-border-circle" src="' . $testimonial['image']['url'] . '" width="64" height="64" alt="' . $testimonial['name'] . '">
    </div>';
endif;

echo '<div class="uk-width-expand">';

// Name
if( isset( $testimonial['name'] ) && $testimonial['name'] != '' ) :
    echo '<div class="customer-testimonial-name">' . $testimonial['name'] . '</div>';
endif;

// Title
if( isset( $testimonial['title'] ) && $testimonial['title'] != '' ) :
    echo '<div class="customer-testimonial-title">' . $testimonial['title'] . '</div>';
endif;

echo '</div></div></div>';