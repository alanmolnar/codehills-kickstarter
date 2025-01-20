<?php
/**
 * Media Class
 *
 * This file contains the Media class which handles the rendering of the media section
 * for the Codehills Kickstarter theme. It includes methods for retrieving content and settings
 * from the WordPress backend and displaying them in a container.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Builder;

use CodehillsKickstarter\Core\Twig;
use CodehillsKickstarter\Core\Builder;
use CodehillsKickstarter\Helpers\Helpers;

class Media extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'media';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'media';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Media';

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
        $media_type         = get_sub_field( 'media_type' );
        $image              = get_sub_field( 'image' );
        $mp4_video          = get_sub_field( 'mp4_video' );
        $youtube_video_id   = get_sub_field( 'youtube_video_id' );
        $vimeo_video_id     = get_sub_field( 'vimeo_video_id' );
        $fullwidth          = get_sub_field( 'fullwidth' );
        
        // Set block details
        $block_details = Helpers::collect( [
            'media_type'        => $media_type,
            'image'             => $image,
            'mp4_video'         => $mp4_video,
            'youtube_video_id'  => $youtube_video_id,
            'vimeo_video_id'    => $vimeo_video_id,
            'fullwidth'         => $fullwidth
        ] );

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