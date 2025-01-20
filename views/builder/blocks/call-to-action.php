<?php
/**
 * Call To Action Block
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
$block_details = $args['block_details'];

// Block style
if( $args['block_style'] ) echo $args['block_style']; ?>

    <div class="call-to-action-block call-to-action-block-<?php echo $block_details->hash; ?> <?php echo $block_details->block_fullscreen ? 'call-to-action-block-fullscreen' : ''; ?> cover-image uk-container uk-container-fullwidth uk-flex uk-flex-<?php echo $block_details->vertical_align; ?>@m uk-flex-bottom">
        <div class="uk-width-<?php echo $block_details->content_width; ?>@l uk-width-1-2@m uk-width-3-4@s">
            <?php
                // Title and subtitle
                get_template_part( 'views/builder/partials/block-titles', null, array(
                    'block_global_settings' => $block_global_settings
                ) );

                // Hero content
                if( $block_details->content != '' ) :
                    echo '<div class="cta-content uk-margin-top">'
                        . $block_details->content .
                    '</div>';
                endif;

                // CTA button
                if( $block_global_settings->have_cta ) :
                    echo '<div class="uk-child-width-auto@s uk-margin-top uk-grid-small" uk-grid>';

                    // Loop through CTAs
                    Builder::get_ctas( $block_global_settings->have_cta );

                    echo '</div>';
                endif;
            ?>
        </div>
    </div>
</section> <!-- Call To Action block end -->