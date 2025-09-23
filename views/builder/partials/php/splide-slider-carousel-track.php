<?php
/**
 * Splide Slider Carousel Track Template Part
 *
 * This template part displays a Splide slider carousel. It includes the slide content and
 * any associated media. This partial can be included in other templates to display Splide sliders.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get details
$slides = isset( $args['slides'] ) ? $args['slides'] : null;

// Splide slider track
echo '<div class="splide__track">
    <ul class="splide__list">';

if( ! empty( $slides ) ) :
    foreach( $slides as $slide ) :
        echo '<li class="splide__slide uk-width-1-1">
            <img class="uk-border-rounded" src="' . esc_url( $slide['url'] ) . '" alt="' . esc_attr( $slide['alt'] ) . '">
        </li>';
    endforeach;
endif;

echo '</ul></div>';