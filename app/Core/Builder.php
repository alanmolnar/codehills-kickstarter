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

use CodehillsKickstarter\Core\Twig;
use CodehillsKickstarter\Core\Widgets;
use CodehillsKickstarter\Core\ThemeFunctions;
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
        $blocks = glob( get_template_directory() . '/app/Builder/*.php' );

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
     * Page builder block main
     * 
     * @since 2.0.0
     * @access public
     * @param int $page_id The page ID
     * @return void
     */
    public static function page_builder( $page_id )
    {
        // If posts page is set, use the page ID from the settings
        if ( get_option( 'page_for_posts' ) && is_home() ) :
            $page_id = get_option( 'page_for_posts' );
        endif;

        // Get the post/page title
        $title = esc_attr( get_the_title( $page_id ) );

        // Check if page builder exist.
        if( class_exists( 'ACF' ) && function_exists( 'have_rows' ) && have_rows( 'page_builder', $page_id  ) ) :
            echo '<section id="page-builder" class="uk-padding-remove">';

            // Render page builder blocks
            self::page_builder_render(  $page_id );

            echo '</section> <!-- #wrapper end -->';
        elseif ( ! empty( get_the_content() ) ) :
            // Get the data
            $data = array(
                // Get post data
                'post'          => array_merge(
                    (array) get_post(),
                    array(
                        'post_content'  => apply_filters( 'the_content', get_the_content() ),
                        'date'          => get_the_date(),
                        'image'         => get_the_post_thumbnail_url( $page_id, 'full' ),
                        'author'        => get_the_author_meta( 'display_name', get_post_field( 'post_author', $page_id ) ),
                        'reading_time'  => ThemeFunctions::get_post_reading_time( get_the_content() ),
                        'terms'         => get_the_terms( $page_id, 'category' ),
                    )
                ),
                // Get previous post data
                'previous_post'    => ( $previous_post = get_previous_post() ) ? array(
                    'title'     => $previous_post->post_title,
                    'permalink' => get_permalink( $previous_post ),
                    'image'     => get_the_post_thumbnail_url( $previous_post, 'full' ),
                ) : null,

                // Get next post data
                'next_post'        => ( $next_post = get_next_post() ) ? array(
                    'title'     => $next_post->post_title,
                    'permalink' => get_permalink( $next_post ),
                    'image'     => get_the_post_thumbnail_url( $next_post, 'full' ),
                ) : null,

                // Get sidebar content
                'sidebar'           => true,
                'sidebar_content'   => Widgets::get_sidebar_content( 'codehills_main_sidebar' ),
            );

            // Article content
            if( ThemeFunctions::twig_enabled() ) :
                // Twig template
                Twig::render( 'template-parts/twig/article-content.twig', $data );
            else:
                // PHP template
                get_template_part( 'views/template-parts/php/article-content', null, $data );
            endif;
        else:
            // Builder notification
            if( ThemeFunctions::twig_enabled() ) :
                // Twig template
                Twig::render( 'template-parts/twig/builder-notification.twig', array( 'title' => $title ) );
            else:
                // PHP template
                get_template_part( 'views/template-parts/php/builder-notification', null, array( 'title' => $title ) );
            endif;
        endif;
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
        $block_style                        = get_sub_field( 'block_style', $page_id );
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
                echo 'class="uk-position-relative uk-section uk-' . $block_style . ' block-id-' . $random_hex . ( $block_class != '' ?  ' ' . $block_class : '') . '"';
                echo ( $block_sticky ? ' uk-sticky' : '');
                echo '>';

                if( $block_background_overlay ) :
                    echo '<div class="uk-overlay-primary uk-position-cover"></div>';
                endif;

                // Section background cover image
                if( $block_background_image != '' && $block_background_mobile_opacity ) :
                    echo '<div class="uk-position-' . $block_background_h_position . ' uk-text-' . $block_background_h_position . ' uk-hidden@m" style="opacity: 0.5">';
                        echo '<img src="' . $block_background_image . '" alt="">';
                    echo '</div>';
                endif;
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
                // Get block global settings
                $block_global_settings = self::get_block_global_settings( $page_id );

                // Block notification
                if( ThemeFunctions::twig_enabled() ) :
                    // Twig template
                    Twig::render( 'template-parts/twig/block-notification.twig', array(
                        'block_global_settings' => $block_global_settings
                    ) );
                else:
                    // PHP template
                    get_template_part( 'views/template-parts/php/block-notification', null, array(
                        'block_global_settings' => $block_global_settings
                    ) );
                endif;
            endif;
        endwhile;
    }

    /**
     * Render page builder block
     * 
     * Render proper page builder block, Twig or PHP
     * 
     * @since 2.1.0
     * @access public
     * @param string $filename The block filename
     * @param array $data The block data
     */
    public static function render_block( $filename, $data )
    {
        // Render the block
        if( ThemeFunctions::twig_enabled() ) :
            // Twig template
            Twig::render( 'builder/blocks/twig/' . $filename . '.twig', $data );
        else:
            // PHP template
            get_template_part( 'views/builder/blocks/php/' . $filename, null, $data );
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
        // Block titles
        $block_titles = isset( $args['block_titles'] ) ? $args['block_titles'] : get_sub_field( 'block_titles', $page_id );

        // Block call to actions
        $have_cta = isset( $args['have_cta'] ) ? $args['have_cta'] : get_sub_field( 'block_ctas', $page_id );
        
        // Return global settings as object
        return (object) array(
            'block_titles'  => $block_titles,
            'have_cta'      => $have_cta
        );
    }

    /**
     * Get cached block data
     * 
     * @since 2.0.0
     * @access protected
     * @param string $cache_key The cache key
     * @param callable $callback The callback function to get the data
     * @param int $expiration The expiration time in seconds
     * @return mixed The cached data or the data from the callback function
     */
    protected static function get_cached_block_data( $cache_key, $callback, $expiration = 300 )
    {
        // Get the cached data
        $data = get_transient( $cache_key );

        // If cached data is not available, call the callback function to get the data
        if( $data === false ) :
            // Call the callback function to get the data
            $data = call_user_func( $callback );

            // Cache the data for the specified expiration time
            set_transient( $cache_key, $data, $expiration );
        endif;

        // Return the data
        return $data;
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
                // CTA button data
                $data = array(
                    'cta_label'             => $cta['label'],
                    'cta_url'               => $cta['url'],
                    'cta_style'             => $cta['style'],
                    'additional_classes'    => $cta['additional_classes'],
                    'additional_attributes' => $cta['additional_attributes'],
                    'new_tab'               => $cta['new_tab']
                );

                // CTA button
                if( ThemeFunctions::twig_enabled() ) :
                    // Twig template
                    Twig::render( 'template-parts/twig/cta-button.twig', $data );
                else:
                    // PHP template
                    get_template_part( 'views/template-parts/php/cta-button', null, $data );
                endif;
            endforeach;
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