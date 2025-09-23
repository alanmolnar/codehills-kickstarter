<?php
/**
 * Codehills Kickstarter Archive Page Template
 *
 * This template displays the archive pages for the Codehills Kickstarter theme.
 * It includes the archive title and a grid of posts filtered by the current taxonomy.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\Core\ThemeFunctions;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Include header
get_header(); ?>

<section class="uk-section">
    <div class="uk-container">
        <h1 class="uk-margin-small-top">
            <?php
                // Get archive title
                echo get_the_archive_title();
            ?>
        </h1>
    </div>
</section>

<section id="page-builder" class="uk-padding-remove">
    <section class="uk-position-relative uk-section-small posts-block-white-bg">
        <div id="posts-with-filters-block">
            <div class="uk-container">
                <div class="posts-with-filters-grid js-filter uk-child-width-1-3@m uk-child-width-1-2@s uk-margin-top uk-margin-bottom" uk-grid uk-height-match=".post-single-box-content">
                    <?php
                        // Get the taxonomy
                        $taxonomy = get_queried_object()->taxonomy;

                        // Main Loop
                        while( have_posts() ) : the_post();
                            // Get post
                            $post = get_post();

                            // Prepare post data
                            $post = (object) array(
                                'ID'                 => $post->ID,
                                'post_title'        => get_the_title( $post->ID ),
                                'post_content'      => $post->post_content,
                                'post_excerpt'      => $post->post_excerpt,
                                'post_date'         => $post->post_date,
                                'permalink'         => get_the_permalink( $post->ID ),
                                'featured_image_url'=> get_the_post_thumbnail_url( $post->ID, 'full' ),
                                'reading_time'      => ThemeFunctions::get_post_reading_time( $post->post_content ),
                                'post_terms'        => get_the_terms( get_the_ID(), $taxonomy )
                            );

                            echo '<div>';

                            // Include post default box
                            get_template_part( 'views/builder/partials/php/post-default-box', null, array(
                                'post'            => $post,
                                'taxonomy'        => $taxonomy,
                                'categories'      => null,
                                'thumbnail_size'  => 'full'
                            ) );

                            echo '</div>';
                        endwhile;
                    ?>
                </div>
            </div>
        </div>
    </section> <!-- Posts with filters section end -->
</section>
    
<?php
    // Include footer
    get_footer();
?>