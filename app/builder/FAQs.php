<?php
/**
 * FAQs Class
 *
 * This file contains the FAQs class which handles the rendering of the hero section
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

class FAQs extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'faqs';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'faqs';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'FAQs';

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

        // Get block details from manual block call
        $content        = isset( $args['content'] ) ? $args['content'] : get_field( self::$id . '_content', 'option' );
        $enable_filters = isset( $args['enable_filters'] ) ? $args['enable_filters'] : get_field( self::$id . '_enable_filters', 'option' );
        $faqs           = isset( $args['faq'] ) ? $args['faq'] : get_field( self::$id, 'option' );

        // Block content
        $content        = get_sub_field( 'content' ) ? get_sub_field( 'content' ) : $content;
        $enable_filters = get_sub_field( 'enable_filters' ) ? get_sub_field( 'enable_filters' ) : $enable_filters;
        $faqs           = get_sub_field( 'faqs' ) ? get_sub_field( 'faqs' ) : get_field( self::$id, 'option' );
        
        // Set block details
        $block_details = Helpers::collect( [
            'content'           => $content,
            'enable_filters'    => $enable_filters,
            'faqs'              => $faqs
        ] );

        // Render the block
        get_template_part( 'views/builder/blocks/' . self::$filename, null, array(
            'page_id'               => $page_id,
            'block_global_settings' => $block_global_settings,
            'block_details'         => $block_details
        ) );
    }
}