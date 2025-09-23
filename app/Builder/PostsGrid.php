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
use CodehillsKickstarter\Core\Twig;
use CodehillsKickstarter\Core\Builder;
use CodehillsKickstarter\Helpers\Helpers;
use CodehillsKickstarter\Core\ThemeFunctions;

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
        $post_box_style = get_sub_field( 'post_box_style' ) ? get_sub_field( 'post_box_style' ) : 'default';
        $columns        = get_sub_field( 'columns' ) ? get_sub_field( 'columns' ) : '4';
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

        // Get the ACF terms field for the taxonomy if set
        if( $taxonomy != null ) :
            switch( $taxonomy ) :
                case 'category':
                    $acf_field_slug = 'categories';
                    break;

                default:
                    $acf_field_slug = null;
            endswitch;
        endif;

        // If the ACF field slug is set, get the terms for the taxonomy and add them to the query arguments
        if( $acf_field_slug != null ) :
            // Get the ACF terms field for the taxonomy
            $terms = get_sub_field( $acf_field_slug );

            // If terms are set, add them to the query arguments
            if( $terms ) :
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'id',
                        'terms'    => $terms
                    )
                );
            endif;
        endif;

        // Query the posts
        $posts_query = new WP_Query( $args );

        // Get taxonomy terms if taxonomy is set, filters are enabled and posts are available
        if( $taxonomy != null && $posts_query->have_posts() && $terms == null ) :
            // Get all news categories
            $categories = get_terms( array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => true
            ) );
        else:
            $categories = get_terms( array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => true,
                'include'    => $terms
            ) );
        endif;

        // Filters
        if( $taxonomy != null && $enable_filters && $posts_query->have_posts() ? $categories : null ) :
            // Get empty array for filters
            $filters = array();

            // Loop through categories
            foreach( $categories as $category ) :
                // Add category to filters
                $filters[$category->slug] = $category->name;
            endforeach;

            // Remove duplicates from associated array
            $filters = array_unique( $filters, SORT_REGULAR );
        else:
            $filters = null;
        endif;

        // Add ACF fields to the posts in the query
        if( $posts_query->have_posts() ) :
            foreach( $posts_query->posts as $index => $post ) :
                // Add the post permalink to the post object
                $post->permalink = get_the_permalink( $post->ID );

                // Add the ACF fields to the post object
                $post->acf = get_fields( $post->ID );

                // Add the featured image URL to the post object
                $post->featured_image_url = get_the_post_thumbnail_url( $post->ID, 'full' );

                // Add the post reading time to the post object
                $post->reading_time = ThemeFunctions::get_post_reading_time( $post->post_content );

                // Add the post terms names and permalink to the post object
                if( $taxonomy != null ) :
                    $terms = get_the_terms( $post->ID, $taxonomy );

                    // If terms are available, add the term names and permalink to the post object
                    if( $terms && ! is_wp_error( $terms ) ) :
                        // Initialize the post_terms array
                        $post->post_terms = array();

                        // Loop through the terms and add them to the post_terms array
                        foreach( $terms as $term ) :
                            $post->post_terms[$term->slug] = array(
                                'name'      => $term->name,
                                'permalink' => get_term_link( $term )
                            );
                        endforeach;
                    else:
                        // If no terms are available, set post_terms to null
                        $post->post_terms = null;
                    endif;
                else:
                    // If no terms are available, set post_terms to null
                    $post->post_terms = null;
                endif;

                // Update the post in the posts array
                $posts_query->posts[$index] = $post;
            endforeach;
        endif;
        
        // Set block details
        $block_details = Helpers::collect( [
            'post_type'         => $post_type,
            'taxonomy'          => $taxonomy,
            'post_box_style'    => $post_box_style,
            'columns'           => $columns,
            'enable_filters'    => $enable_filters,
            'filters'           => $filters,
            'content'           => $content,
            'posts_query'       => $posts_query,
            'categories'        => $taxonomy != null && $posts_query->have_posts() ? $categories : null
        ] );

        // Reset the post data
        wp_reset_postdata();

        // Block data
        $data = array(
            'page_id'               => $page_id,
            'block_global_settings' => $block_global_settings,
            'block_details'         => $block_details
        );

        // Render the block
        Builder::render_block( self::$filename, $data );
    }
}