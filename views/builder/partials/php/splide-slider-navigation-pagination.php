<?php
/**
 * Splide Slider Navigation & Pagination Template Part
 *
 * This template part displays Splide slider navigation arrows and pagination.
 * It renders the previous/next arrow buttons and the pagination list for the Splide carousel.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit; ?>

<div class="splide__arrows splide__arrows--ltr custom-splide-arrows uk-width-1-1">
    <div class="uk-flex uk-flex-center uk-flex-middle uk-width-1-1">
        <!-- Previous arrow -->
        <div>
            <a class="splide__arrow splide__arrow--prev uk-button uk-button-secondary" href="javascript:void(0);" uk-icon="icon: arrow-left; ratio: 1.25;"></a>
        </div>
        
        <!-- Pagination -->
        <div>
            <ul class="splide__pagination custom-splide-pagination uk-padding-remove"></ul>
        </div>

        <!-- Next arrow -->
        <div>
            <a class="splide__arrow splide__arrow--next uk-button uk-button-secondary" href="javascript:void(0);" uk-icon="icon: arrow-right; ratio: 1.25;"></a>
        </div>
    </div>
</div>