<?php
/**
 * Hero Section Block
 *
 * This file is responsible for rendering the hero section of the website.
 * It retrieves the necessary content and settings from the WordPress backend
 * and displays them in a styled container with animations.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

use CodehillsKickstarter\Core\Builder;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get block global settings
$block_global_settings = $args['block_global_settings'];

// Get block details
$block_details = $args['block_details']; ?>

    <div class="hero-section-block uk-container uk-flex uk-flex-middle uk-flex-center uk-text-center">
        <div class="uk-width-3-5@l">
            <?php
                // Title and subtitle
                get_template_part( 'views/builder/partials/block-titles', null, array(
                    'block_global_settings' => $block_global_settings
                ) );

                // Hero content
                if( $block_details->content != '' ) :
                    echo '<div class="uk-flex uk-flex-center uk-margin-medium-top">
                        <div class="hero-content uk-width-3-4@m">'
                            . $block_details->content .
                        '</div>
                    </div>';
                endif;

                // CTA button
                if( $block_global_settings->have_cta ) :
                    echo '<div class="uk-child-width-auto@s uk-flex-center uk-margin-medium-top uk-grid-small" uk-grid>';

                    // Loop through CTAs
                    Builder::get_ctas( $block_global_settings->have_cta );

                    echo '</div>';
                endif;
            ?>
        </div>
    </div>
</section> <!-- Hero Section block end -->