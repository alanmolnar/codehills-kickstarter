<?php
/**
 * ThemeSetup Class
 *
 * This file contains the ThemeSetup class which handles the main setup process
 * for the Codehills Kickstarter theme. It includes methods for initializing theme
 * features, enqueuing scripts and styles, and setting up custom post types and widgets.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter;

use CodehillsKickstarter\Core\Twig;
use CodehillsKickstarter\Core\Widgets;
use CodehillsKickstarter\Core\Taxonomies;
use CodehillsKickstarter\Helpers\Helpers;
use CodehillsKickstarter\Core\ThemePlugins;
use CodehillsKickstarter\Core\AdminFunctions;
use CodehillsKickstarter\Core\ThemeFunctions;
use CodehillsKickstarter\Core\EnqueueBackend;
use CodehillsKickstarter\Core\CustomPostTypes;
use CodehillsKickstarter\Core\EnqueueFrontend;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

/**
 * ThemeSetup Class
 *
 * This class handles the main setup process for the Codehills Studio theme.
 *
 * @since 2.0.0
 * @package CodehillsKickstarter
 */
class ThemeSetup {
    /**
     * Instance
     *
     * @since 2.0.0
     * @access private
     * @static
     *
     * @var ThemeSetup The single instance of the class.
     */
    private static $instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 2.0.0
     * @access public
     *
     * @return ThemeSetup An instance of the class.
     */
    public static function instance()
    {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     * Class constructor
     *
     * Register theme functions action hooks and filters
     *
     * @since 2.0.0
     * @access public
     */
    public function __construct()
    {
        // Customize the ACF JSON save path
        add_filter( 'acf/settings/save_json', array( $this, 'theme_acf_json_save_point' ), 10, 3 );

        // Customize the ACF JSON load path
        add_filter( 'acf/settings/load_json', array( $this, 'theme_acf_json_load_point' ) );

        // Enqueue theme styles and scripts for the front-end
        add_filter( 'wp_enqueue_scripts', array( $this, 'theme_enqueue_frontend' ), 99 );

        // Enqueue theme styles and scripts for the back-end
        add_filter( 'admin_enqueue_scripts', array( $this, 'theme_enqueue_backend' ) );

        // Add theme options page
        add_action( 'init', array( $this, 'add_theme_options_page' ) );

        // Delete default plugins when backend is loaded
        add_action( 'admin_init', array( $this, 'delete_default_plugins' ) );
    }

    /**
     * Customize the ACF JSON save path
     *
     * @since 2.0.0
     * @access public
     * @param string $path The path to the ACF JSON save point
     * @return string The path to the ACF JSON save point
     */
    public function theme_acf_json_save_point( $path )
    {
        return get_stylesheet_directory() . '/resources/acf-json';
    }

    /**
     * Customize the ACF JSON load path
     *
     * @since 1.0.0
     * @access public
     * @param array $paths The paths to the ACF JSON load points
     * @return array The paths to the ACF JSON load points
     */
    public function theme_acf_json_load_point( $paths )
    {
        // Remove the original path (optional).
        unset( $paths[0] );
    
        // Append the new path and return it.
        $paths[] = get_stylesheet_directory() . '/resources/acf-json';
    
        return $paths;
    }

    /**
     * Theme setup class constructor
     * 
     * @since 1.2.2
     * @access public
     */
    public function init()
    {
        // Initialize homepage and remove sample page
        $this->initialize_homepage();

        // Add theme support
        $this->theme_support();

        // Register menus
        $this->register_menus();

        // Set image sizes
        $this->set_image_sizes();

        // Instantiate Twig class
        $twig = Twig::instance();

        // Instantiate ThemeFunctions class
        $theme_functions = ThemeFunctions::instance();

        // Instantiate CustomPostTypes class
        $custom_post_types = CustomPostTypes::instance();

        // Instantiate Taxonomies class
        $taxonomies = Taxonomies::instance();

        // Instantiate Widgets class
        $widgets = Widgets::instance();

        // Instantiate ThemePlugins class
        $theme_plugins = ThemePlugins::instance();

        // Initialize admin functions
        $admin_functions = AdminFunctions::instance();
    }

    /**
     * Initialize homepage
     * 
     * Initialize homepage and remove sample page
     * 
     * @since 2.0
     * @access public
     */
    public function initialize_homepage()
    {
        // Reset the homepage variable
        $homepage = null;

        // Query for the homepage by title
        $query = new \WP_Query( array(
            'post_type'      => 'page',
            'post_status'    => 'any',
            'title'          => 'Kickstarter Home',
            'posts_per_page' => 1,
        ) );

        // If homepage exists, set it
        if ( $query->have_posts() ) {
            $homepage = $query->posts[0];
        }

        // Reset post data
        wp_reset_postdata();

        // If homepage doesn't exist, create it
        if ( ! $homepage ) :
            // Check if the 'kickstarter_home' value exist in options
            $kickstarter_home_option = get_option( 'kickstarter_home' );

            // If 'kickstarter_home' meta key doesn't exist, create homepage
            if ( ! $kickstarter_home_option ) :
                // Homepage post details
                $homepage = array(
                    'post_title'    => 'Kickstarter Home',
                    'post_type'     => 'page',
                    'post_status'   => 'publish',
                    'post_author'   => 1,
                );

                // Insert the post into the database
                $homepage_id = wp_insert_post( $homepage );

                // Page post-creation actions
                if( $homepage_id && ! is_wp_error( $homepage_id ) ) :
                    // Add 'kickstarter_home' value to options
                    add_option( 'kickstarter_home', true );

                    // Set homepage as front page
                    update_option( 'page_on_front', $homepage_id );
                    update_option( 'show_on_front', 'page' );
                endif;
            endif;
        endif;

        // Reset the sample page variable
        $sample_page = null;

        // Query for the homepage by title
        $query = new \WP_Query( array(
            'post_type'      => 'page',
            'post_status'    => 'any',
            'title'          => 'Sample Page',
            'posts_per_page' => 1,
        ) );

        // Delete 'Sample Page' if it exists
        if ( $sample_page ) :
            wp_delete_post( $sample_page->ID );
        endif;

        // Reset post data
        wp_reset_postdata();
    }

    /**
     * Delete default plugin
     * 
     * Delete 'Akismet Anti-spam: Spam Protection' and 'Hello Dolly' plugins
     * 
     * @since 2.0
     * @access public
     */

    public function delete_default_plugins()
    {
        // Check if the 'plugin_akismet_removed' value exist in options
        $plugin_akismet_removed_option = get_option( 'plugin_akismet_removed' );

        // Check if Akismet plugin is active
        if ( ! $plugin_akismet_removed_option && file_exists( WP_PLUGIN_DIR . '/akismet/akismet.php' ) ) :
            // Deactivate Akismet plugin
            deactivate_plugins( 'akismet/akismet.php' );

            // Delete Akismet plugin
            delete_plugins( array( 'akismet/akismet.php' ) );

            // Add option to indicate Akismet plugin has been removed
            add_option( 'plugin_akismet_removed', true );

            echo 'Akismet';
        endif;

        // Check if the 'plugin_hello_dolly_removed' value exist in options
        $plugin_hello_dolly_removed_option = get_option( 'plugin_hello_dolly_removed' );

        // Check if Hello Dolly plugin is active
        if ( ! $plugin_hello_dolly_removed_option && file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) :
            // Deactivate Hello Dolly plugin
            deactivate_plugins( 'hello.php' );

            // Delete Hello Dolly plugin
            delete_plugins( array( 'hello.php' ) );

            // Add option to indicate Hello Dolly plugin has been removed
            add_option( 'plugin_hello_dolly_removed', true );

            echo 'Hello Dolly';
        endif;
    }

    /**
     * Theme support
     * 
     * Add theme support for various features
     * 
     * @since 2.0
     * @access public
     */
    public function theme_support()
    {
        // Define and register starter content to showcase the theme on new sites
        $starter_content = array(
            'widgets' => array(
                // Place core-defined widgets in the sidebar area
                'codehills_main_sidebar' => array(
                    'search',
                )
            ),

            // Set up nav menus for each of the two areas registered in the theme
            'nav_menus' => array(
                // Assign a menu to the 'header' location
                'primary' => array(
                    'name' => __('Main Nav', ThemeFunctions::TEXT_DOMAIN)
                ),

                // Assign a menu to the 'footer_nav' location
                'footer_nav' => array(
                    'name' => __('Footer Nav', ThemeFunctions::TEXT_DOMAIN)
                ),
            ),
        );

        // Adding theme supported features
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'custom-logo' );
        add_theme_support( 'yoast-seo-breadcrumbs' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
        add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio' ) );
        add_theme_support( 'starter-content', $starter_content );
        add_theme_support( 'woocommerce' );
    }

    /**
     * Register menus
     * 
     * Register theme menus
     * 
     * @since 2.0
     * @access public
     */
    public function register_menus()
    {
        // Register theme menus
        register_nav_menus( array(
            'primary'       => __( 'Main Nav', ThemeFunctions::TEXT_DOMAIN ),
            'footer_nav'    => __( 'Footer Nav', ThemeFunctions::TEXT_DOMAIN ),
        ));
    }

    /**
     * Set image sizes
     * 
     * Set theme image sizes
     * 
     * @since 2.0
     * @access public
     */
    public function set_image_sizes()
    {
        // Set image sizes
        add_image_size( 'post_featured', 1140, 500, true );
    }

    /**
     * Enqueue theme styles and scripts
     * 
     * Enqueue theme styles and scripts for the front-end
     * 
     * @since 2.0
     * @access public
     */
    public function theme_enqueue_frontend()
    {
        // Instantiate Enqueue class
        $theme_enqueue = new EnqueueFrontend();

        // Initialize the theme enqueue
        $theme_enqueue->init();
    }

    /**
     * Enqueue theme styles and scripts
     * 
     * Enqueue theme styles and scripts for the back-end
     * 
     * @since 2.0
     * @access public
     */
    public function theme_enqueue_backend()
    {
        // Instantiate Enqueue class
        $theme_enqueue = new EnqueueBackend();

        // Initialize the theme enqueue
        $theme_enqueue->init();
    }

    /**
     * Add theme options page
     * 
     * Add theme options page using ACF
     * 
     * @since 2.0
     * @access public
     */
    public function add_theme_options_page()
    {
        // Add options page
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title'    => 'Codehills Kickstarter Settings',
                'menu_title'    => 'Codehills Kickstarter Settings',
                'menu_slug'     => 'codehills-kickastarter-settings',
                'capability'    => 'edit_posts',
                'redirect'      => false
            ));
        }
    }
}