<?php
/**
 * Form Class
 *
 * This file contains the Form class which handles the rendering of the form section
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

class Form extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'form';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'form';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Form';

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
        $form_shortcode = get_sub_field( 'form_shortcode' );
        $form_bg_color  = get_sub_field( 'form_background_color' ) ? get_sub_field( 'form_background_color' ) : '#ffffff';
        $content        = get_sub_field( 'content' );
        
        // Set block details
        $block_details = Helpers::collect( [
            'form_shortcode'    => $form_shortcode,
            'form_bg_color'     => $form_bg_color,
            'content'           => $content,
        ] );

        // Render the block
        get_template_part( 'views/builder/blocks/' . self::$filename, null, array(
            'page_id'               => $page_id,
            'block_global_settings' => $block_global_settings,
            'block_details'         => $block_details
        ) );
    }
}