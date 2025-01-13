<?php
/**
 * Builder Class
 *
 * This file contains the Builder class which handles the main functions
 * for the Codehills Kickstarter theme. This class is used to define the main
 * functions for the theme.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

use CodehillsKickstarter\Builder\WordPressContent;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Create theme functions class
class Builder {
    /**
     * Instance
     *
     * @since 2.0.0
     * @access private
     * @static
     *
     * @var Builder The single instance of the class.
     */
    private static $instance = null;

    /**
     * Namespace prefix
     * 
     * @since 2.0.0
     * @access private
     * @var string The namespace prefix
     */

    private static $namespace_prefix = 'CodehillsKickstarter\\Builder\\';

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 2.0.0
     * @access public
     *
     * @return Builder An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     *  Theme functions class constructor
     *
     * Register theme functions action hooks and filters
     *
     * @since 2.0.0
     * @access public
     */
    public function __construct()
    {
        // Instantiate all blocks from /app/builder directory
        $blocks = glob( get_template_directory() . '/app/builder/*.php' );

        // Loop through blocks
        foreach( $blocks as $block ) :
            // Get block class name
            $block_class_name = str_replace( ' ', '', ucwords( str_replace( '_', ' ', basename( $block, '.php' ) ) ) );

            // If block class name have 'Wordpress' in it, replace it with 'WordPress'
            $block_class_name = self::$namespace_prefix . str_replace( 'Wordpress', 'WordPress', $block_class_name );

            // Check if class exists
            if ( class_exists( $block_class_name ) && strpos( $block_class_name, 'Index' ) === false ) :
                // Instantiate block class
                $block = new $block_class_name();
            endif;
        endforeach;
    }

    /**
     * Page builder render
     * 
     * Render page builder blocks
     * 
     * @since 2.0.0
     * @access public
     * @param int $page_id The page ID
     * @return void
     */
    public static function page_builder_render( $page_id )
    {
        // Loop through blocks.
        while ( have_rows( 'page_builder', $page_id ) ) : the_row();
            // Convert block identifier from get_row_layout() to the class name that don't contain spaces or underscore, first letter is uppercase
            $block_class_name = str_replace( ' ', '', ucwords( str_replace( '_', ' ', get_row_layout() ) ) );

            // If block class name have 'Wordpress' in it, replace it with 'WordPress'
            $block_class_name = self::$namespace_prefix . str_replace( 'Wordpress', 'WordPress', $block_class_name );

            // Check if block is disabled
            $block_disabled = get_sub_field('disable_block');

            // Check if class exists
            if ( class_exists( $block_class_name ) ) :
                // Render block if it's not disabled
                if ( ! $block_disabled ) :
                    $block_class_name::render();
                endif;
            else:
                // Block notification
                get_template_part( 'views/template-parts/block-notification', null, array(
                    'page_id' => $page_id
                ) );
            endif;
        endwhile;
    }

    /**
     * Page builder block start
     * 
     * @since 2.0.0
     * @access public
     * @param int $page_id The page ID
     * @return void
     */
    public static function page_builder_block_start( $page_id )
    {
        // Creat random string of numbers for class name
        $random_hex = bin2hex(random_bytes(4));

        // Section settings
        $block_id                           = get_sub_field( 'block_id', $page_id );
        $block_class                        = get_sub_field( 'block_class', $page_id );
        $block_sticky                       = get_sub_field( 'block_sticky', $page_id );
        $block_mobile_spacing               = get_sub_field( 'block_mobile_spacing', $page_id );
        $block_tablet_spacing               = get_sub_field( 'block_tablet_spacing', $page_id );
        $block_desktop_spacing              = get_sub_field( 'block_desktop_spacing', $page_id );
        $block_background_color             = get_sub_field( 'block_background_color', $page_id );
        $block_background_image             = get_sub_field( 'block_background_image', $page_id );
        $block_background_overlay           = get_sub_field( 'block_background_overlay', $page_id );
        $block_background_mobile_opacity    = get_sub_field( 'block_background_mobile_opacity', $page_id );
        $block_background_h_position        = get_sub_field( 'block_background_h-position', $page_id );
        $block_background_v_position        = get_sub_field( 'block_background_v-position', $page_id );
        $block_background_size              = get_sub_field( 'block_background_size', $page_id ); ?>

        <style>
            <?php
                // Tablet
                if( $block_desktop_spacing ) :
                    echo '.block-id-' . $random_hex . ' {';
                    echo ( $block_mobile_spacing['padding_mobile_top'] != '' ? 'padding-top: ' . $block_mobile_spacing['padding_mobile_top'] . 'px;' : '' );
                    echo ( $block_mobile_spacing['padding_mobile_bottom'] != '' ? 'padding-bottom: ' . $block_mobile_spacing['padding_mobile_bottom'] . 'px;' : '' );
                    echo ( $block_mobile_spacing['margin_mobile_top'] != '' ? 'margin-top: ' . $block_mobile_spacing['margin_mobile_top'] . 'px;' : '' );
                    echo ( $block_mobile_spacing['margin_mobile_bottom'] != '' ? 'margin-bottom: ' . $block_mobile_spacing['margin_mobile_bottom'] . 'px;' : '' );
                    echo ( $block_background_color != '' ? 'background-color: ' . $block_background_color . ';' : '' );
                    echo ( $block_background_image != '' && ! $block_background_mobile_opacity ? 'background-image: url(' . esc_url( $block_background_image ) . ');' : '' );
                    echo ( $block_background_h_position != '' || $block_background_v_position != '' ? 'background-position: ' . $block_background_h_position . ' ' .  $block_background_v_position . ';' : '' );
                    echo ( $block_background_size != 'default' ? 'background-size: ' . $block_background_size . ';' : '' );
                    echo 'background-repeat: no-repeat;';
                    echo '}';
                endif;

                // Tablet
                if( $block_desktop_spacing ) : ?>
                    @media screen and (min-width: 960px) {
                        <?php 
                        echo '.block-id-' . $random_hex . ' {';
                        echo ( $block_tablet_spacing['padding_tablet_top'] != '' ? 'padding-top: ' . $block_tablet_spacing['padding_tablet_top'] . 'px;' : '');
                        echo ( $block_tablet_spacing['padding_tablet_bottom'] != '' ? 'padding-bottom: ' . $block_tablet_spacing['padding_tablet_bottom'] . 'px;' : '');
                        echo ( $block_tablet_spacing['margin_tablet_top'] != '' ? 'margin-top: ' . $block_tablet_spacing['margin_tablet_top'] . 'px;' : '');
                        echo ( $block_tablet_spacing['margin_tablet_bottom'] != '' ? 'margin-bottom: ' . $block_tablet_spacing['margin_tablet_bottom'] . 'px;' : '');
                        echo ( $block_background_image != '' && $block_background_mobile_opacity ? 'background-image: url(' . esc_url( $block_background_image ) . ');' : '' );
                        echo ' }';
                        ?>
                    }
                <?php endif;

                // Desktop
                if( $block_desktop_spacing ) : ?>
                    @media screen and (min-width: 1200px) {
                        <?php 
                        echo '.block-id-' . $random_hex . ' {';
                        echo ( $block_desktop_spacing['padding_desktop_top'] != '' ? 'padding-top: ' . $block_desktop_spacing['padding_desktop_top'] . 'px;' : '');
                        echo ( $block_desktop_spacing['padding_desktop_bottom'] != '' ? 'padding-bottom: ' . $block_desktop_spacing['padding_desktop_bottom'] . 'px;' : '');
                        echo ( $block_desktop_spacing['margin_desktop_top'] != '' ? 'margin-top: ' . $block_desktop_spacing['margin_desktop_top'] . 'px;' : '');
                        echo ( $block_desktop_spacing['margin_desktop_bottom'] != '' ? 'margin-bottom: ' . $block_desktop_spacing['margin_desktop_bottom'] . 'px;' : '');
                        echo ( $block_background_image != '' && $block_background_mobile_opacity ? 'background-image: url(' . esc_url( $block_background_image ) . ');' : '' );
                        echo ' }';
                        ?>
                    }
                <?php endif;
            ?>
        </style>

        <section
            <?php
                echo ( $block_id != '' ? 'id="' . $block_id . '"' : '');
                echo ( $block_class != '' ? 'class="uk-position-relative uk-section block-id-' . $random_hex . ' ' . $block_class . '"' : 'class="uk-position-relative uk-section block-id-' . $random_hex . '"');
                echo ( $block_sticky ? ' uk-sticky' : '');
                echo '>';

                if( $block_background_overlay ) :
                    echo '<div class="uk-overlay-default uk-position-cover uk-position-z-index"></div>';
                endif;

                // Section background cover image
                if( $block_background_image != '' && $block_background_mobile_opacity ) :
                    echo '<div class="uk-position-' . $block_background_h_position . ' uk-text-' . $block_background_h_position . ' uk-hidden@m" style="opacity: 0.5">';
                        echo '<img src="' . $block_background_image . '" alt="">';
                    echo '</div>';
                endif;
    }

    /**
     * Page builder block main
     * 
     * @since 2.0.0
     * @access public
     * @param int $page_id The page ID
     * @return void
     */
    public static function page_builder( $page_id )
    {
        // Check value exists.
        if( have_rows( 'page_builder' ) ) :
            echo '<section id="page-builder" class="uk-padding-remove">';
                // Render page builder blocks
                Builder::page_builder_render(  $page_id  );
            echo '</section> <!-- #wrapper end -->';
        elseif ( ! empty( get_the_content() ) ) : 
            // Article content
            get_template_part( 'views/template-parts/article-content' );
        else:
            // Builder notification
            get_template_part( 'views/template-parts/builder-notification' );
        endif;
    }

    /**
     * Get block global settings for the page
     * 
     * @since 2.0.0
     * @access public
     * @param int $page_id The page ID
     * @param array $args The block arguments
     * @param string $prefix The field prefix
     * @return object The block global settings
     */
    public static function get_block_global_settings( $page_id, $args = null, $prefix = '' )
    {
        // Get block details from manual block call
        $title          = isset( $args['title'] ) ? $args['title'] : get_field( $prefix . '_title', 'option' );
        $title_tag      = isset( $args['title_tag'] ) ? $args['title_tag'] : get_field( $prefix . '_title_tag', 'option' );
        $title_style    = isset( $args['title_style'] ) ? $args['title_style'] : get_field( $prefix . '_title_style', 'option' );
        $subtitle       = isset( $args['subtitle'] ) ? $args['subtitle'] : get_field( $prefix . '_subtitle', 'option' );
        $subtitle_tag   = isset( $args['subtitle_tag'] ) ? $args['subtitle_tag'] : get_field( $prefix . '_subtitle_tag', 'option' );
        $subtitle_style = isset( $args['subtitle_style'] ) ? $args['subtitle_style'] : get_field( $prefix . '_subtitle_style', 'option' );

        // Block title and subtitle
        $title          = get_sub_field( 'block_title', $page_id ) ? get_sub_field( 'block_title', $page_id ) : $title;
        $title_tag      = get_sub_field( 'block_title_tag', $page_id ) ? get_sub_field( 'block_title_tag', $page_id ) : $title_tag;
        $title_style    = get_sub_field( 'block_title_style', $page_id ) ? get_sub_field( 'block_title_style', $page_id ) : $title_style;
        $subtitle       = get_sub_field( 'block_subtitle', $page_id ) ? get_sub_field( 'block_subtitle', $page_id ) : $subtitle;
        $subtitle_tag   = get_sub_field( 'block_subtitle_tag', $page_id ) ? get_sub_field( 'block_subtitle_tag', $page_id ) : $subtitle_tag;
        $subtitle_style = get_sub_field( 'block_subtitle_style', $page_id ) ? get_sub_field( 'block_subtitle_style', $page_id ) : $subtitle_style;

        // Block call to actions
        $have_cta       = isset( $args['have_cta'] ) ? $args['have_cta'] : get_sub_field( 'block_ctas', $page_id );
        
        // Return global settings as object
        return (object) array(
            // Block title and subtitle
            'title'             => $title,
            'title_tag'         => $title_tag,
            'title_style'       => $title_style,
            'subtitle'          => $subtitle,
            'subtitle_tag'      => $subtitle_tag,
            'subtitle_style'    => $subtitle_style,

            // Block call to actions
            'have_cta'          => $have_cta
        );
    }

    /**
     * Get block call to actions
     * 
     * @since 2.0.0
     * @access public
     * @param array $ctas The call to actions
     * @return void
     */
    public static function get_ctas( $ctas = null )
    {
        // Check if block call to actions are passed as argument or it is called from the block
        if( $ctas != null ) :
            // Loop through manually called CTAs
            foreach ( $ctas as $cta ) :
                // CTA button
                get_template_part( 'views/template-parts/cta-button', null, array(
                    'cta_label'             => $cta['label'],
                    'cta_url'               => $cta['url'],
                    'cta_style'             => $cta['style'],
                    'additional_classes'    => $cta['additional_classes'],
                    'additional_attributes' => $cta['additional_attributes'],
                    'new_tab'               => $cta['new_tab']
                ) );
            endforeach;
        else:
            // Loop through CTAs repeater
            while( have_rows( 'block_ctas' ) ) : the_row();
                $cta_label              = get_sub_field( 'label' );
                $cta_url                = get_sub_field( 'url' );
                $cta_style              = get_sub_field( 'style' ) ? get_sub_field( 'style' ) : 'uk-button-primary';
                $additional_classes     = get_sub_field( 'additional_classes' );
                $additional_attributes  = get_sub_field( 'additional_attributes' );
                $new_tab                = get_sub_field( 'new_tab' );

                // CTA button
                get_template_part( 'views/template-parts/cta-button', null, array(
                    'cta_label'             => $cta_label,
                    'cta_url'               => $cta_url,
                    'cta_style'             => $cta_style,
                    'additional_classes'    => $additional_classes,
                    'additional_attributes' => $additional_attributes,
                    'new_tab'               => $new_tab
                ) );
            endwhile;
        endif;
    }

    /**
     * Check if block is present
     * 
     * @since 2.0.2
     * @access public
     * @param string $block_name The block name
     * @return bool The block flag
     */
    public static function has_block( $block_name )
    {
        // Get page id
        $page_id = get_the_ID();

        // Block flag
        $block_flag = false;

        // Check if block is present
        if ( have_rows( 'page_builder', $page_id ) ) :
            // Loop through blocks
            while ( have_rows( 'page_builder', $page_id ) ) : the_row();
                if ( get_row_layout() == $block_name ) :
                    $block_flag = true;
                endif;
            endwhile;
        endif;

        return $block_flag;
    }
}