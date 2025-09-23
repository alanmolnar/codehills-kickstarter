<?php
/**
 * Posts Grid Block
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

    <div class="posts-grid-block" <?php echo $block_details->enable_filters ? 'uk-filter="target: .js-filter"' : ''; ?>>
        <div class="uk-container">
            <?php
                // Title / content grid
                get_template_part( 'views/builder/partials/php/title-content-grid', null, array(
                    'block_details'         => $block_details,
                    'block_global_settings' => $block_global_settings,
                    'title_content'         => ! empty( $block_details->title_content ) ? $block_details->title_content : ''
                ) );

                // Filters
                if( $block_details->enable_filters && $block_details->posts_query->have_posts() && $block_details->categories != null ) : ?>
                    <div class="posts-filter uk-margin-large-top uk-margin-medium-bottom">
                        <div class="uk-container">
                            <div class="uk-position-relative" tabindex="-1" uk-slider="active: first; finite: true;">
                                <ul class="uk-slider-items uk-subnav uk-subnav-pill uk-flex-nowrap uk-margin-remove">
                                    <?php
                                        // Loop through filters
                                        foreach( $block_details->filters as $key => $value ) : ?>
                                            <li uk-filter-control=".tag-<?php echo esc_attr( $key ); ?>"><a href="#"><?php echo wp_kses_post( $value ); ?></a></li>
                                        <?php endforeach;
                                    ?>

                                    <li class="uk-active" uk-filter-control><a href="#">All</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif;

                // Posts
                if( $block_details->posts_query->have_posts() ) :
                    echo '<div id="posts-grid" class="js-filter uk-child-width-1-' . $block_details->columns . '@m uk-child-width-1-2@s uk-grid-match uk-grid-small uk-margin-large-top" uk-grid>';
                            // Loop through posts
                            foreach( $block_details->posts_query->posts as $post ) :
                                // Prepare post terms for filters
                                $filters = array();

                                if( ! empty( $post->post_terms ) ) :
                                    foreach( $post->post_terms as $key => $term ) :
                                        $filters[] = 'tag-' . $key;
                                    endforeach;
                                endif;

                                echo '<div class="' . implode( ' ', $filters ) . '">';

                                // Include post box
                                get_template_part( 'views/builder/partials/php/' . $block_details->post_type . '-' . $block_details->post_box_style . '-box', null, array(
                                    'post'          => $post,
                                    'filters'       => $filters,
                                    'taxonomy'      => $block_details->taxonomy,
                                    'categories'    => $block_details->categories
                                ) );

                                echo '</div>';
                            endforeach;
                    echo '</div>';
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
</section> <!-- Posts Grid block end -->