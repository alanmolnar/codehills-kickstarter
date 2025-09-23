<?php
/**
 * WordPress Content Block
 *
 * This file is part of the Codehills Kickstarter theme's page builder section. It handles
 * the rendering of WordPress content blocks within the theme. The file includes functions
 * to retrieve and display the content of a specified page, applying necessary filters and
 * actions to ensure the content is properly formatted and integrated into the theme's
 * layout.
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

    <div class="uk-container">
        <?php
            // Title and subtitle
            get_template_part( 'views/builder/partials/php/block-titles', null, array(
                'block_global_settings' => $block_global_settings
            ) );

            // Content
            echo '<div class="uk-margin-top">' . $block_details->content . '</div>';

            // CTA button
            if( $block_global_settings->have_cta ) :
                echo '<div class="uk-child-width-auto@s uk-flex-center uk-flex-left@m uk-margin-medium-top uk-grid-small" uk-grid>';

                // Loop through CTAs
                Builder::get_ctas( $block_global_settings->have_cta );

                echo '</div>';
            endif;
        ?>
    </div>
</section> <!-- WordPress content block end -->