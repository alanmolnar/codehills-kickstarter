<?php
/**
 * Post Default Box Template Part
 *
 * This template part displays a single post box. It retrieves the necessary data such as taxonomy
 * and thumbnail size from the arguments and displays the post with a featured image and a link.
 * This partial can be included in other templates to display individual post items.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get post object
$post = isset( $args['post'] ) && ! empty( $args['post'] ) ? $args['post'] : null;

// Get taxonomy
$taxonomy = ! empty( $args['taxonomy'] ) ? $args['taxonomy'] : null;

// Get categories
$categories = ! empty( $args['categories'] ) ? $args['categories'] : null;

// Get filters
$filters = !empty($args['filters']) ? $args['filters'] : []; ?>

<article class="post-single-box uk-position-relative <?php echo esc_attr( implode( ' ', $filters ) ); ?>">
    <?php
        // Featured Image
        if( $post->featured_image_url != '' ) : ?>
            <div class="product-single-box-image">
                <a href="<?php echo esc_url( $post->permalink ); ?>">
                    <img src="<?php echo esc_url( $post->featured_image_url ); ?>" width="640" height="360" alt="<?php echo esc_attr( $post->title ); ?>">
                </a>
            </div>
        <?php endif;
    ?>

    <div class="post-single-box-details">
        <?php
            // Categories
            if( ! empty( $post->post_terms ) ) : ?>
                <div class="post-terms-list uk-flex">
                    <?php
                        if ( is_array( $post->post_terms ) ) :
                            foreach( $post->post_terms as $term ) :
                                if( is_object( $term ) ) :
                                    echo '<a href="' . esc_url( $term->permalink ) . '">' . esc_html( $term->name ) . '</a>';
                                elseif ( is_array( $term ) && isset( $term['permalink'], $term['name'] ) ) :
                                    echo '<a href="' . esc_url( $term['permalink'] ) . '">' . esc_html( $term['name'] ) . '</a>';
                                endif;
                            endforeach;
                        endif;
                    ?>
                </div>
            <?php endif;
        ?>

        <div class="post-single-box-content">
            <h3>
                <a href="<?php echo esc_url( $post->permalink ); ?>">
                    <?php echo esc_html( $post->post_title ); ?>
                </a>
            </h3>

            <div class="post-single-box-excerpt uk-margin-small-top">
                <?php echo esc_html( ! empty( $post->post_excerpt ) ? $post->post_excerpt : wp_trim_words( wp_strip_all_tags( $post->post_content ), 20, '...' ) ); ?>
            </div>
        </div>

        <div class="post-meta uk-flex-between uk-margin-top" uk-grid>
            <div class="uk-width-expand">
                <p class="post-date"><?php echo esc_html( date( 'F j, Y', strtotime( $post->post_date ) ) ); ?></p>
            </div>

            <div class="uk-width-auto">
                <p class="post-date"><?php echo esc_html( $post->reading_time ); ?></p>
            </div>
        </div>
    </div>
</article>