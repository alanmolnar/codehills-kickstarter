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
                // Filters
                if( $block_details->enable_filters && $block_details->posts_query->have_posts() && $block_details->categories != null ) : ?>
                    <div class="posts-filter uk-margin-large-bottom">
                        <div class="uk-container">
                            <div class="uk-position-relative" tabindex="-1" uk-slider="active: first; finite: true;">
                                <ul class="uk-slider-items uk-subnav uk-subnav-pill uk-flex-nowrap uk-flex-center uk-margin-remove">
                                    <li class="uk-active" uk-filter-control><a href="#">All</a></li>

                                    <?php
                                        // Get empty array for filters
                                        $filters = array();

                                        // Loop through categories
                                        foreach( $block_details->categories as $category ) :
                                            // Add category to filters
                                            $filters[][$category->slug] = $category->name;
                                        endforeach;

                                        // Remove duplicates from associated array
                                        $filters = array_unique( $filters, SORT_REGULAR );

                                        // Loop through filters
                                        foreach( $filters as $filter ) :
                                            echo '<li uk-filter-control=".tag-' . key( $filter ) . '"><a href="#">' . current( $filter ) . '</a></li>';
                                        endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif;

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
                    echo '<div class="uk-child-width-auto@s uk-flex-center uk-margin-medium-top uk-grid-small" uk-grid>';

                    // Loop through CTAs
                    Builder::get_ctas( $block_global_settings->have_cta );

                    echo '</div>';
                endif;

                // Posts
                if( $block_details->posts_query->have_posts() ) :
                    echo '<div id="posts-grid" class="js-filter" uk-grid>';

                    while( $block_details->posts_query->have_posts() ) : $block_details->posts_query->the_post();
                        // Get template part
                        get_template_part( 'views/builder/partials/article-box', null, array(
                            'taxonomy'          => $block_details->taxonomy,
                            'categories'        => $block_details->categories,
                            'thumbnail_size'    => 'full'
                        ) );
                    endwhile;

                    echo '</div>';
                endif;

                echo '<div class="uk-child-width-auto@s uk-flex-center uk-margin-large-top uk-grid-small" uk-grid>';

                // Loadmore button
                get_template_part( 'views/template-parts/cta-button', null, array(
                    'cta_label'             => 'Load more news',
                    'cta_url'               => 'javascript:void(0);',
                    'cta_style'             => 'outline',
                    'additional_classes'    => 'js-loadmore',
                    'additional_attributes' => '',
                    'new_tab'               => false
                ) );

                echo '</div>';
                
                // Hidden input for paged parameter
                echo '<input type="hidden" id="paged" value="1">';

                // Hidden input for max pages
                echo '<input type="hidden" id="max_pages" value="' . $block_details->posts_query->max_num_pages . '">';
            ?>
        </div>
    </div>
</section> <!-- Posts Grid block end -->