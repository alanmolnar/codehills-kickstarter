<?php
/**
 * AdminFunctions Class
 *
 * This file contains the AdminFunctions class which handles the main functions
 * for the Codehills Kickstarter theme. This class is used to define the main
 * functions for the theme.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Create theme functions class
class AdminFunctions {
    /**
     * Instance
     *
     * @since 2.0.0
     * @access private
     * @static
     *
     * @var AdminFunctions The single instance of the class.
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
     * @return AdminFunctions An instance of the class.
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
        // Add custom styles to WordPress backend
        add_action( 'admin_head', array( $this, 'admin_custom_style' ), 999 );
        add_action( 'login_enqueue_scripts', array( $this, 'admin_custom_style' ), 999 );

        // Remove Dashboard widgets
        add_action( 'wp_dashboard_setup', array( $this, 'remove_dashboard_widgets' ), 999 );

        // Remove admin bar for all users except administrators
        add_action( 'show_admin_bar', array( $this, 'remove_admin_bar' ) );

        // Remove comments from client area completely
        add_action( 'admin_init', array( $this, 'remove_comments' ) );

        // Remove comments page and option page in menu
        add_action( 'admin_menu', array( $this, 'remove_comments_pages' ) );

        // Remove comments links from admin bar
        add_action( 'init', array( $this, 'remove_comments_link_from_admin_bar' ), 60 );

        // Close comments on the front-end
        add_filter( 'comments_open', '__return_false', 20, 2 );
        add_filter( 'pings_open', '__return_false', 20, 2 );

        // Hide existing comments
        add_filter( 'comments_array', '__return_empty_array', 10, 2 );
    }

    /**
     * Add custom styles to WordPress backend
     *
     * @since 2.0.0
     * @access public
     */
    public function admin_custom_style()
    { ?>
        <style>
            /* Fonts */
            body, #wpadminbar *:not([class="ab-icon"]), .wp-core-ui, .media-menu, .media-frame *, .media-modal * {
                font-family: 'Outfit', sans-serif !important;
            }
            #login h1 a, .login h1 a {
                background-image: url(<?php echo site_url(); ?>/wp-content/uploads/2024/08/logo.svg);
                height: 40px;
                width: 165px;
                background-size: 165px 40px;
                background-repeat: no-repeat;
                padding-bottom: 10px;
            }
        </style>
    <?php }

    /**
     * Remove Dashboard widgets
     * 
     * @since 2.0.0
     * @access public
     */
    public function remove_dashboard_widgets()
    {
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    }

    /**
     * Remove admin bar for all users except administrators
     * 
     * @since 2.0.0
     * @access public
     * @return boolean
     */
    public function remove_admin_bar()
    {
        // Check if the user is not an administrator or editor and if not, remove the admin bar
        if( ! current_user_can( 'administrator' ) && ! current_user_can( 'editor' ) && ! is_admin() ) :
            return false;
        endif;
    }

    // Remove comments from client area completely

    /**
     * Remove comments from client area completely
     * 
     * @since 2.0.0
     * @access public
     */
    public function remove_comments()
    {
        // Redirect any user trying to access comments page
        global $pagenow;
        
        // Check if the user is trying to access the comments page and redirect them to the admin page
        if( $pagenow === 'edit-comments.php' || $pagenow === 'options-discussion.php' ) :
            wp_redirect( admin_url() );

            exit;
        endif;

        // Remove comments metabox from dashboard
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

        // Disable support for comments and trackbacks in post types
        foreach( get_post_types() as $post_type ) :
            if( post_type_supports($post_type, 'comments' ) ) :
                remove_post_type_support( $post_type, 'comments' );
                remove_post_type_support( $post_type, 'trackbacks' );
            endif;
        endforeach;
    }

    /**
     * Remove comments page and option page in menu
     * 
     * @since 2.0.0
     * @access public
     */
    public function remove_comments_pages()
    {
        // Remove comments page and option page
        remove_menu_page( 'edit-comments.php' );
        remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    }

    /**
     * Remove comments links from admin bar
     * 
     * @since 2.0.0
     * @access public
     */
    public function remove_comments_link_from_admin_bar()
    {
        if( is_admin_bar_showing() ) :
            remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
        endif;
    }
}