<?php
/**
 * Content Block
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

    <div class="content-block">
        <div class="uk-container">
            <div class="uk-flex uk-flex-center">
                <div class="uk-width-<?php echo $block_details->content_width; ?>@m uk-text-<?php echo $block_details->text_align; ?>">
                    <?php
                        // Title and subtitle
                        get_template_part( 'views/builder/partials/php/block-titles', null, array(
                            'block_global_settings' => $block_global_settings
                        ) );

                        // Content
                        if( $block_details->content != '' ) :
                            echo '<div class="uk-margin-top">' . $block_details->content . '</div>';
                        endif;

                        // CTA button
                        if( $block_global_settings->have_cta ) :
                            echo '<div class="uk-child-width-auto@s uk-flex-' . $block_details->text_align . ' uk-margin-medium-top uk-grid-small" uk-grid>';

                            // Loop through CTAs
                            Builder::get_ctas( $block_global_settings->have_cta );

                            echo '</div>';
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section> <!-- Content block end -->