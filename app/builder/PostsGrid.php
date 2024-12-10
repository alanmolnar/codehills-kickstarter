<?php
/**
 * PostsGrid Class
 *
 * This file contains the PostsGrid class which handles the rendering of the posts grid section
 * for the Codehills Kickstarter theme. It includes methods for retrieving content and settings
 * from the WordPress backend and displaying them in a container.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Builder;

use WP_Query;
use CodehillsKickstarter\Core\Builder;
use CodehillsKickstarter\Helpers\Helpers;

class PostsGrid extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'posts_grid';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'posts-grid';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Posts Grid';

    /**
     * Prepare the block data and render the block
     * 
     * @since 2.0.0
     * @access public
     * @return view
     */
    public static function render( $args = null )
    {
        // Get page id
        $page_id = get_the_ID();

        // Do action from Builder class
        Builder::page_builder_block_start( $page_id );

        // Block global settings
        $block_global_settings = Builder::get_block_global_settings( $page_id, $args, self::$id );

        // Block content
        $post_type      = get_sub_field( 'post_type' );
        $taxonomy       = get_sub_field( 'taxonomy' );
        $enable_filters = get_sub_field( 'enable_filters' );
        $content        = get_sub_field( 'content' );

        // Query arguments, show first 8 posts, then load more
        $args = array(
            'post_type'         => $post_type,
            'posts_per_page'    => 8,
            'paged'             => 1,
            'orderby'           => 'date',
            'order'             => 'DESC'
        );

        // Query the posts
        $posts_query = new WP_Query( $args );

        if( $taxonomy != null && $enable_filters && $posts_query->have_posts() ) :
            // Get all news categories
            $categories = get_terms( array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => true
            ) );
        endif;
        
        // Set block details
        $block_details = Helpers::collect( [
            'post_type'         => $post_type,
            'taxonomy'          => $taxonomy,
            'enable_filters'    => $enable_filters,
            'content'           => $content,
            'posts_query'       => $posts_query,
            'categories'        => $categories
        ] );

        // Reset the post data
        wp_reset_postdata();

        // Render the block
        get_template_part( 'views/builder/blocks/' . self::$filename, null, array(
            'page_id'               => $page_id,
            'block_global_settings' => $block_global_settings,
            'block_details'         => $block_details
        ) );
    }
}