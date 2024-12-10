<?php
/**
 * Article Box Template Part
 *
 * This template part displays a single article box. It retrieves the necessary data such as taxonomy
 * and thumbnail size from the arguments and displays the article with a featured image and a link.
 * This partial can be included in other templates to display individual article items.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

if( ! defined( 'WPINC' ) ) :
    die;
endif;

// Get partial data
$categories     = $args['categories'];
$thumbnail_size = $args['thumbnail_size'];

// Set empty string for filters class
$filters = '';

// Loop through categories
if( $categories != null ) :
    foreach ( $categories as $category ) :
        // Add category to filters
        $filters .= ' tag-' . $category->slug;
    endforeach;
endif; ?>

<article class="post-single-box uk-position-relative <?php echo $filters; ?>">
    <div class="post-single-box-wrapper uk-cover-container uk-light">
        <a href="<?php echo esc_url( get_the_permalink() ); ?>">
            <?php 
                // Grab the url for the img
                $featured_image = get_the_post_thumbnail_url( get_the_ID(), $thumbnail_size );

                // Set featured image or placeholder
                if( $featured_image != '' ) :
                    echo '<img src="' . esc_url( $featured_image ) . '" alt="' . esc_attr( get_the_title() ) . '" uk-cover>';
                endif;
            ?>

            <div class="uk-overlay-primary uk-position-cover"></div>
        </a>
    </div>

    <div class="post-single-box-details">
        <?php
            // Display terms as links, with commas
            if( $categories != null ) :
                echo '<div class="simple-terms-list">';

                foreach( $categories as $term ) :
                    echo '<a href="' . get_term_link( $term )  . '">' . $term->name . ( next( $categories ) ? ',&nbsp;' : '' ) . '</a>';
                endforeach;

                echo '</div>';
            endif;
        ?>

        <div class="post-single-box-content uk-margin-small-top">
            <h3>
                <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                    <?php
                        // Post title
                        echo get_the_title();
                    ?>
                </a>
            </h3>

            <div class="post-single-box-excerpt uk-margin-small-top">
                <?php
                    // Excerpt
                    the_excerpt();
                ?>
            </div>
        </div>
    </div>
</article>