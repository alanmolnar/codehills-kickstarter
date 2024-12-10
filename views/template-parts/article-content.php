<?php
/**
 * Article Content Template Part
 *
 * This template part displays the content of an article. It includes the article title
 * and the article content. This partial can be included in other templates to display
 * the content of an article.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get the post title
$title = esc_attr( get_the_title() );

// Grab the url for the featured image
$featured_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>

<!-- Article
============================================= -->
<article id="main" class="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="uk-container">
        <div class="article-content uk-width-2-3@m">
            <div class="article-featured-image'">
                <?php
                    // Featured image
                    if ( $featured_image_url != '' ) :
                        echo '<div class="article-featured-image">
                            <img src="' . esc_url( $featured_image_url ) . '" alt="' . $title . '">
                        </div>';
                    endif;
                ?>
            </div>

            <h1><?php echo $title; ?></h1>

            <?php
                // Excerpt
                the_content();
            ?>
        </div>
    </div>
</article><!-- Article end -->