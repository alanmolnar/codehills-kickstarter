<?php
/**
 * ContentMediaGrid Class
 *
 * This file contains the ContentMediaGrid class which handles the rendering of the content / media
 * grid sectionfor the Codehills Kickstarter theme. It includes methods for retrieving content
 * and settings from the WordPress backend and displaying them in a container.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Builder;

use CodehillsKickstarter\Core\Builder;
use CodehillsKickstarter\Helpers\Helpers;

class ContentMediaGrid extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'content_media_grid';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'content-media-grid';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Content Media Grid';

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
        $layout             = get_sub_field( 'layout' );
        $media_column_width = get_sub_field( 'media_column_width' );
        $vertical_align     = get_sub_field( 'vertical_align' );
        $fullwidth          = get_sub_field( 'fullwidth' );
        $viewport_height    = get_sub_field( 'viewport_height' );
        $content            = get_sub_field( 'content' );
        $media              = get_sub_field( 'media' );
        
        // Set block details
        $block_details = Helpers::collect( [
            'layout'             => $layout,
            'media_column_width' => $media_column_width,
            'vertical_align'     => $vertical_align,
            'fullwidth'          => $fullwidth,
            'viewport_height'    => $viewport_height,
            'content'            => $content,
            'media'              => $media
        ] );

        // Render the block
        get_template_part( 'views/builder/blocks/' . self::$filename, null, array(
            'page_id'               => $page_id,
            'block_global_settings' => $block_global_settings,
            'block_details'         => $block_details
        ) );
    }
}