<?php
/**
 * CallToAction Class
 *
 * This file contains the CallToAction class which handles the rendering of the call to action section
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
use CodehillsKickstarter\Core\ThemeFunctions;

class CallToAction extends Builder
{    
    /**
     * The ACF flexible layout's unique identifier
     *
     * @var string
     */
    protected static $id = 'call_to_action';

    /**
     * The layout's filename
     *
     * @var string
     */
    protected static $filename = 'call-to-action';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Call To Action';

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
        $content            = get_sub_field( 'content' );
        $content_width      = get_sub_field( 'content_width' ) ? get_sub_field( 'content_width' ) : '1-3';
        $image_desktop      = get_sub_field( 'image_desktop' );
        $image_mobile       = get_sub_field( 'image_mobile' );
        $vertical_align     = get_sub_field( 'vertical_align' ) ? get_sub_field( 'vertical_align' ) : 'top';
        $block_fullscreen   = get_sub_field( 'block_fullscreen' );

        // Create 8 characters random hash
        $hash = substr( md5( rand() ), 0, 8 );
        
        // Set block details
        $block_details = Helpers::collect( [
            'content'           => $content,
            'content_width'     => $content_width,
            'image_desktop'     => $image_desktop,
            'image_mobile'      => $image_mobile,
            'vertical_align'    => $vertical_align,
            'block_fullscreen'  => $block_fullscreen,
            'hash'              => $hash
        ] );

        $block_style = '<style>';

        // Block inline style for background image
        if( $image_mobile ) :
            $block_style .= '.call-to-action-block-' . $hash . ' {
                background-image: url(' . $image_mobile['url'] . ');
            }';
        endif;

        // Block inline style for background image on desktop
        if( $image_desktop ) :
            $block_style .= '@media screen and (min-width: 960px) {
                .call-to-action-block-' . $hash . ' {
                    background-image: url(' . $image_desktop['url'] . ');
                }
            }';
        endif;

        $block_style .= '</style>';

        // Block data
        $data = array(
            'page_id'               => $page_id,
            'block_global_settings' => $block_global_settings,
            'block_details'         => $block_details,
            'block_style'           => $block_style
        );

        // Render the block
        if( ThemeFunctions::twig_enabled() ) :
            // Twig template
            Twig::render( 'builder/blocks/' . self::$filename . '.twig', $data );
        else:
            // PHP template
            get_template_part( 'views/builder/blocks/' . self::$filename, null, $data );
        endif;
    }
}