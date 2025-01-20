<?php
/**
 * Form Block
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

    <div class="form-block">
        <div class="uk-container">
            <?php
                // Title and subtitle
                get_template_part( 'views/builder/partials/block-titles', null, array(
                    'block_global_settings' => $block_global_settings
                ) );

                // Content
                if( $block_details->content != '' ) :
                    echo '<div class="uk-margin-top">' . $block_details->content . '</div>';
                endif;

                // CTA button
                if( $block_global_settings->have_cta ) :
                    echo '<div class="uk-child-width-auto@s uk-margin-medium-top uk-grid-small" uk-grid>';

                    // Loop through CTAs
                    Builder::get_ctas( $block_global_settings->have_cta );

                    echo '</div>';
                endif;
            ?>

            <div class="form-wrapper uk-margin-top" style="background-color: <?php echo $block_details->form_bg_color; ?>">
                <?php
                    // Form
                    if( $block_details->form_shortcode != '' ) :
                        echo $block_details->form_shortcode;
                    endif;
                ?>
            </div>
        </div>
    </div>
</section> <!-- Form block end -->