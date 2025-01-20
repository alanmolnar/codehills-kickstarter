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
                                echo '<div>';

                                // Include article single box
                                get_template_part( 'views/builder/partials/article-box', null, array(
                                    'taxonomy'          => $taxonomy,
                                    'categories'        => null,
                                    'thumbnail_size'    => 'full'
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