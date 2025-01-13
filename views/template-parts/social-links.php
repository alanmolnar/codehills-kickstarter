<?php
/**
 * Social Links Template Part
 *
 * This file retrieves social media links from the theme options and displays them as a list of icons.
 * Each icon is wrapped in a link that opens in a new tab and has appropriate attributes for security.
 *
 * @since 2.0.2
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Social media list
if( have_rows( 'social', 'option' ) ) :
    echo '<ul class="uk-iconnav">';

    while( have_rows( 'social', 'option' ) ) : the_row();
        // Get details
        $url    = get_sub_field( 'url' );
        $icon   = get_sub_field( 'icon' );

        echo '<li>
            <a class="transition" href="' . $url . '" rel="noopener noreferrer nofollow" target="_blank">
                <img class="uk-preserve" src="' . $icon['url'] . '" width="20" alt="' . $icon['alt'] . '" uk-svg>
            </a>
        </li>';
    endwhile;

    echo '</ul>';
endif;