<?php
/**
 * Twig Class
 *
 * This class is responsible for initializing and configuring the Twig templating engine
 * for the Codehills Kickstarter theme. It sets up the Twig environment, loads templates
 * from the specified directory, and adds custom functions to Twig for use within templates.
 *
 * The class provides methods to:
 * - Initialize the Twig environment with specified settings.
 * - Add custom functions to Twig for use in templates.
 * - Render templates with provided data.
 *
 * @since 2.1.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
 
// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;
 
// Create Twig class
class Twig {
    /**
     * Instance
     *
     * @since 2.1.0
     * @access private
     * @static
     *
     * @var ThemeFunctions The single instance of the class.
     */
    private static $instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 2.1.0
     * @access public
     *
     * @return ThemeFunctions An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     * Twig instance
     * 
     * @since 2.1.0
     */
    private static $twig;

    /**
     *  Theme functions class constructor
     *
     * Register theme functions action hooks and filters
     *
     * @since 2.1.0
     * @access public
     */
    public function __construct()
    {
        // Initialize Twig
        $this->initialize_twig();
    }

    /**
     * Initialize Twig
     * 
     * @since 2.1.0
     * @access private
     */
    private static function initialize_twig()
    {
        // Define paths
        $twig_template_dir = get_template_directory() . '/templates/twig';

        // Define paths for Twig templates
        $loader = new FilesystemLoader( get_template_directory() . '/views' );
        $loader->addPath( $twig_template_dir );

        // Initialize Twig environment
        self::$twig = new Environment( $loader, array(
            'cache' => get_template_directory() . '/cache',
            'debug' => true, // Enable debug for development
        ) );

        // Enable debug extension
        self::$twig->addExtension( new DebugExtension() );

        // Pass global variables to all templates
        self::pass_global_variables( self::$twig );

        // Add Codehills Kickstarter theme functions to Twig
        self::add_theme_functions( self::$twig );

        // Add WordPress functions to Twig
        self::add_wordpress_functions( self::$twig );

        // Add translation functions to Twig
        self::add_translation_functions( self::$twig );
    }

    /**
     * Load and render Twig templates.
     */
    public static function load_twig_template( $template_path )
    {
        // Define paths
        $twig_template_dir = get_template_directory() . '/templates/twig';

        // Ensure the template file name is relative to the registered path
        $template_name = str_replace( $twig_template_dir . '/', '', $template_path );

        // Extract WordPress data and render Twig
        $data = self::get_page_details( $template_name );

        // Render the Twig template
        echo self::$twig->render( $template_name, $data );

        // Prevent further processing
        exit;
    }

    /**
     * Get Twig instance
     * 
     * @since 2.1.0
     * @return Environment
     * @access public
     */
    public static function get_twig()
    {
        return self::$twig;
    }

    /**
     * Render Twig template
     * 
     * @since 2.1.0
     * @param string $template
     * @param array $data
     * @access public
     */
    public static function render( $template, $data = array() )
    {
        // Check if template exists
        if( self::$twig->getLoader()->exists( $template ) ) :
            echo self::$twig->render( $template, $data );
        else:
            // Get block global settings
            $block_global_settings = Builder::get_block_global_settings( get_the_ID() );

            // Twig template
            Twig::render( 'template-parts/block-notification.twig', array(
                'block_global_settings' => $block_global_settings
            ) );
        endif;
    }

    /**
     * Get page details
     * 
     * @since 2.1.0
     * @param string $template_name
     * @return array
     * @access private
     */
    private static function get_page_details( $template_name )
    {
        // Remove file extension
        $template_name = str_replace( '.twig', '', $template_name );

        // Get page details
        switch( $template_name ) :
            // 404 page
            case '404' :
                $data = array(
                    'title'         => get_field( '404_title', 'option' ) ? get_field( '404_title', 'option' ) : 'Error 404',
                    'content'       => get_field( '404_content', 'option' ) ? get_field( '404_content', 'option' ) : __( 'Sorry, the page you are looking for has been moved or could not be found.', ThemeFunctions::TEXT_DOMAIN ),
                    'cta_one_label' => get_field( '404_cta_one_label', 'option' ) ? get_field( '404_cta_one_label', 'option' ) : 'Go Back Home',
                    'cta_one_url'   => get_field( '404_cta_one_url', 'option' ) ? get_field( '404_cta_one_url', 'option' ) : home_url(),
                    'cta_two_label' => get_field( '404_cta_two_label', 'option' ) ? get_field( '404_cta_two_label', 'option' ) : '',
                    'cta_two_url'   => get_field( '404_cta_two_url', 'option' ) ? get_field( '404_cta_two_url', 'option' ) : null,
                    'bg_image'      => get_field( '404_background_image', 'option' )
                );
                break;

            // Archive page
            case 'archive' :
                $data = array(
                    'title'     => get_the_archive_title(),
                    'taxonomy'  => ! is_woocommerce() ? get_queried_object()->taxonomy : null,
                    'posts'     => get_posts( array(
                        'post_type' => get_post_type(),
                        'tax_query' => ! is_woocommerce() ? array(
                            array(
                                'taxonomy' => get_queried_object()->taxonomy,
                                'field'    => 'term_id',
                                'terms'    => get_queried_object()->term_id
                            )
                        ) : null
                    ) )
                );
                break;

            // WooCommerce shop page
            case 'woocommerce/shop' :
                $data = array(
                    'title'     => get_the_title(),
                    'content'   => get_the_content()
                );
                break;

            // Default page
            default:
                $data = array(
                    'title'     => get_the_title(),
                    'content'   => get_the_content()
                );
        endswitch;

        return $data;
    }

    /**
     * Pass global variables to all templates
     * 
     * @since 2.1.0
     * @param Environment $twig
     * @access private
     */
    private static function pass_global_variables( $twig )
    {
        // Pass global variables to all templates
        self::$twig->addGlobal( 'site_url', get_site_url() );
        self::$twig->addGlobal( 'blog_info', get_bloginfo( 'name' ) );
        self::$twig->addGlobal( 'theme_url', get_template_directory_uri() );
        self::$twig->addGlobal( 'uikit_menu_walker', new UIKitMenuWalker() );
        self::$twig->addGlobal( 'theme_text_domain', ThemeFunctions::TEXT_DOMAIN );
    }
    /**
     * Add theme functions to Twig
     * 
     * @since 2.1.0
     * @param Environment $twig
     * @access private
     */
    private static function add_theme_functions( $twig )
    {
        // Register the Builder::page_builder function
        self::$twig->addFunction( new TwigFunction( 'page_builder', function ( $id ) {
            return Builder::page_builder( $id );
        } ) );

        // Register the Builder::get_ctas function
        self::$twig->addFunction( new TwigFunction( 'get_ctas', function ( $ctas ) {
            return Builder::get_ctas( $ctas );
        } ) );
    }

    /**
     * Add WordPress functions to Twig
     * 
     * @since 2.1.0
     * @param Environment $twig
     * @access private
     */
    private static function add_wordpress_functions( $twig )
    {
        $twig->addFunction( new TwigFunction( 'bloginfo', 'bloginfo' ) );
        $twig->addFunction( new TwigFunction( 'body_class', 'body_class' ) );
        $twig->addFunction( new TwigFunction( 'dd', 'dd' ) );
        $twig->addFunction( new TwigFunction( 'get_field', 'get_field' ) );
        $twig->addFunction( new TwigFunction( 'get_sub_field', 'get_sub_field' ) );
        $twig->addFunction( new TwigFunction( 'get_term_link', 'get_term_link' ) );
        $twig->addFunction( new TwigFunction( 'get_the_permalink', 'get_the_permalink' ) );
        $twig->addFunction( new TwigFunction( 'get_the_post_thumbnail_url', 'get_the_post_thumbnail_url' ) );
        $twig->addFunction( new TwigFunction( 'get_the_title', 'get_the_title' ) );
        $twig->addFunction( new TwigFunction( 'has_nav_menu', 'has_nav_menu' ) );
        $twig->addFunction( new TwigFunction( 'have_posts', 'have_posts' ) );
        $twig->addFunction( new TwigFunction( 'have_rows', 'have_rows' ) );
        $twig->addFunction( new TwigFunction( 'language_attributes', 'language_attributes' ) );
        $twig->addFunction( new TwigFunction( 'post_class', 'post_class' ) );
        $twig->addFunction( new TwigFunction( 'the_content', 'the_content' ) );
        $twig->addFunction( new TwigFunction( 'the_row', 'the_row' ) );
        $twig->addFunction( new TwigFunction( 'wp_footer', 'wp_footer' ) );
        $twig->addFunction( new TwigFunction( 'wp_head', 'wp_head' ) );
        $twig->addFunction( new TwigFunction( 'wp_nav_menu', 'wp_nav_menu' ) );
    }

    /**
     * Add translation functions to Twig
     * 
     * @since 2.1.0
     * @param Environment $twig
     * @access private
     */
    private static function add_translation_functions( $twig )
    {
        self::$twig->addFunction( new TwigFunction( '__', '__' ) );
        self::$twig->addFunction( new TwigFunction( '_e', '_e' ) );
    }
}