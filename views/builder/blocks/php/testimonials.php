<?php
/**
 * Testimonials Block
 *
 * This file is responsible for rendering the block section of the website.
 * It retrieves the necessary content and settings from the WordPress backend
 * and displays them in a container.
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

    <div class="testimonials-block">
        <div class="uk-container">
            <div class="uk-text-center">
                <?php
                    // Title and subtitle
                    get_template_part( 'views/builder/partials/php/block-titles', null, array(
                        'block_global_settings' => $block_global_settings
                    ) );

                    // Content
                    if( $block_details->content != '' ) :
                        echo '<div class="uk-margin-top">' . $block_details->content . '</div>';
                    endif;
                ?>
            </div>
        </div>

        <div class="uk-container uk-margin-top">
            <?php
                // Testimonials
                if( $block_details->testimonials ): ?>
                    <div class="uk-position-relative" tabindex="-1" uk-slider="autoplay: true;">
                        <div class="uk-slider-items uk-child-width-1-3@l uk-child-width-1-2@s uk-grid uk-grid-xlarge uk-visible@s">
                            <?php
                                // Clone testimonials
                                for( $i = 0; $i < 2; $i++ ) :
                                    // Loop through testimonials
                                    foreach( $block_details->testimonials as $testimonial ) :
                                        // Get template part
                                        get_template_part( 'views/builder/partials/php/testimonial-row', null, array(
                                            'testimonial' => $testimonial
                                        ) );
                                    endforeach;
                                endfor;
                            ?>
                        </div>
                    </div>
                <?php endif;

                // CTA button
                if( $block_global_settings->have_cta ) :
                    echo '<div class="uk-child-width-auto@m uk-margin-medium-top uk-grid-small" uk-grid>';

                    // Loop through CTAs
                    Builder::get_ctas( $block_global_settings->have_cta );

                    echo '</div>';
                endif;
            ?>
        </div>
    </div>
</section> <!-- Testimonials block end -->