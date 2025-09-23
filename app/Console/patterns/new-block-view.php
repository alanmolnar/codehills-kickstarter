<?php
/**
 * New block view pattern
 *
 * This file is responsible for creating a new block view pattern in the Codehills Kickstarter theme.
 * It retrieves necessary information from the console input to generate the block view.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Get the block html class name from the console input
$html_class_name = $args['html_class_name'];

// Get block name from the console input
$block_name = $args['block_name'];

echo '<?php
/**
 * ' . $block_name . ' Block
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
defined( \'WPINC\' ) || exit;

// Get block global settings
$block_global_settings = $args[\'block_global_settings\'];

// Get block details
$block_details = $args[\'block_details\']; ?>

    <div class="' . $html_class_name . '-block">
        <div class="uk-container">
            <?php
                // Title and subtitle
                get_template_part( \'views/builder/partials/php/block-titles\', null, array(
                    \'block_global_settings\' => $block_global_settings
                ) );

                // CTA button
                if( $block_global_settings->have_cta ) :
                    echo \'<div class="uk-child-width-auto@s uk-flex-center uk-margin-medium-top uk-grid-small" uk-grid>\';

                    // Loop through CTAs
                    Builder::get_ctas( $block_global_settings->have_cta );

                    echo \'</div>\';
                endif;
            ?>
        </div>
    </div>
</section> <!-- ' . $block_name . ' block end -->';