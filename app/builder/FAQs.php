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

use CodehillsKickstarter\Core\Twig;
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
        $content                    = isset( $args['content'] ) ? $args['content'] : get_field( self::$id . '_content', 'option' );
        $enable_filters             = isset( $args['enable_filters'] ) ? $args['enable_filters'] : get_field( self::$id . '_enable_filters', 'option' );
        $faqs                       = isset( $args['faq'] ) ? $args['faq'] : get_field( self::$id, 'option' );
        $disable_global_title       = isset( $args['disable_global_title'] ) ? $args['disable_global_title'] : false;
        $disable_global_subtitle    = isset( $args['disable_global_subtitle'] ) ? $args['disable_global_subtitle'] : false;
        $disable_global_content     = isset( $args['disable_global_content'] ) ? $args['disable_global_content'] : false;

        // Block content
        $content                                        = get_sub_field( 'content' ) ? get_sub_field( 'content' ) : $content;
        $enable_filters                                 = get_sub_field( 'enable_filters' ) ? get_sub_field( 'enable_filters' ) : $enable_filters;
        $faqs                                           = get_sub_field( 'faqs' ) ? get_sub_field( 'faqs' ) : get_field( self::$id, 'option' );
        $block_global_settings->disable_global_title    = get_sub_field( 'disable_global_title' ) ? get_sub_field( 'disable_global_title' ) : $disable_global_title;
        $block_global_settings->disable_global_subtitle = get_sub_field( 'disable_global_subtitle' ) ? get_sub_field( 'disable_global_subtitle' ) : $disable_global_subtitle;
        $disable_global_content                         = get_sub_field( 'disable_global_content' ) ? get_sub_field( 'disable_global_content' ) : $disable_global_content;

        // Get empty array for filters
        $filters = array();

        // Loop through faqs
        foreach( $faqs as $faq ) :
            if( isset( $faq['category'] ) ) :
                // Get category
                $category = $faq['category'];

                // Add category to filters
                $filters[$category['value']] = $category['label'];
            endif;
        endforeach;

        // Remove duplicates from associated array
        $filters = array_unique( $filters, SORT_REGULAR );
        
        // Set block details
        $block_details = Helpers::collect( [
            'content'           => $content,
            'enable_filters'    => $enable_filters,
            'filters'           => $filters,
            'faqs'              => $faqs
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