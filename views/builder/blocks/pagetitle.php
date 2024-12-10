<?php
/**
 * Pagetitle Block
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

    <div class="pagetitle-block">
        <?php
            // Mobile image
            if( $block_details->mobile_image ) :
                echo '<div class="cover-image uk-position-left uk-width-1-1 uk-height-1-1 uk-hidden@m" style="background-image: url(' . esc_url( $block_details->mobile_image['url'] ) . ');"></div>';
            endif;
        ?>

        <div class="uk-container uk-text-center uk-text-left@m">
            <div uk-grid>
                <div class="uk-width-<?php echo $block_details->content_width; ?>@m">
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
                            echo '<div class="uk-child-width-auto@s uk-flex-center uk-flex-left@m uk-margin-medium-top uk-grid-small" uk-grid>';

                            // Loop through CTAs
                            Builder::get_ctas( $block_global_settings->have_cta );

                            echo '</div>';
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section> <!-- Pagetitle block end -->