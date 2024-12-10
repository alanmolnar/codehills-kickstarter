<?php
/**
 * Pagetitle Class
 *
 * This file contains the Pagetitle class which handles the rendering of the pagetitle section
 * for the Codehills Kickstarter theme. It includes methods for retrieving content and settings
 * from the WordPress backend and displaying them in a container.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Builder;

use CodehillsKickstarter\Core\Builder;
use CodehillsKickstarter\Helpers\Helpers;

class Pagetitle extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'pagetitle';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'pagetitle';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Pagetitle';

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

        // Generate a unique cache key
        $cache_key = 'page_builder_block_' . self::$id . '_' . $page_id;

        // Try to get the cached data
        $cached_data = get_transient( $cache_key );

        if ( $cached_data !== false ) :
            // Use the cached data
            $block_global_settings  = $cached_data['block_global_settings'];
            $block_details          = $cached_data['block_details'];
        else:
            // Block global settings
            $block_global_settings = Builder::get_block_global_settings( $page_id, $args, self::$id );

            // Block content
            $content        = get_sub_field( 'content' );
            $content_width  = get_sub_field( 'content_width' ) ? get_sub_field( 'content_width' ) : '1-2';
            $mobile_image   = get_sub_field( 'mobile_image' );
            
            // Set block details
            $block_details = Helpers::collect( [
                'content'       => $content,
                'content_width' => $content_width,
                'mobile_image'  => $mobile_image
            ] );

            // Store the data in the cache for 12 hours
            // set_transient( $cache_key, [
            //     'block_global_settings' => $block_global_settings,
            //     'block_details'         => $block_details
            // ], 12 * HOUR_IN_SECONDS);
        endif;

        // Render the block
        get_template_part( 'views/builder/blocks/' . self::$filename, null, array(
            'page_id'               => $page_id,
            'block_global_settings' => $block_global_settings,
            'block_details'         => $block_details
        ) );
    }
}