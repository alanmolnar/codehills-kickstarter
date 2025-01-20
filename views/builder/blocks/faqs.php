<?php
/**
 * FAQs Block
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

    <div class="faq-block" <?php echo $block_details->enable_filters ? 'uk-filter="target: .js-filter"' : ''; ?>>
        <?php
            // Filters
            if( $block_details->enable_filters && $block_details->faqs ) : ?>
                <div class="faqs-filter uk-margin-large-bottom">
                    <div class="uk-container">
                        <ul class="uk-subnav uk-subnav-pill uk-flex uk-flex-center uk-margin-remove">
                            <li class="uk-active" uk-filter-control><a href="#">All</a></li>

                            <?php
                                // Loop through filters
                                foreach( $block_details->filters as $key => $value ) :
                                    echo '<li uk-filter-control=".tag-' . $key . '"><a href="#">' . $value . '</a></li>';
                                endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
            <?php endif;
        ?>

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

                // Accordion
                if( $block_details->faqs ):
                    echo '<ul class="' . ( $block_details->enable_filters ? 'js-filter' : '') . ' uk-margin-medium-top uk-margin-remove-bottom" uk-accordion="active: 0">';

                    // Loop through FAQs
                    foreach( $block_details->faqs as $faq ) :
                        // Get template part
                        get_template_part( 'views/builder/partials/faq-row', null, array(
                            'faq' => $faq
                        ) );
                    endforeach;

                    echo '</ul>';
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
</section> <!-- FAQs block end -->