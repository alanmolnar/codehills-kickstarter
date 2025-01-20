<?php
/**
 * Content Class
 *
 * This file contains the Content class which handles the rendering of the content section
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

class Content extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'content';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'content';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Content';

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
        $content_width  = get_sub_field( 'content_width' );
        $text_align     = get_sub_field( 'text_align' );
        $content        = get_sub_field( 'content' );
        
        // Set block details
        $block_details = Helpers::collect( [
            'content_width' => $content_width,
            'text_align'    => $text_align,
            'content'       => $content,
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