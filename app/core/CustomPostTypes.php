<?php
/**
 * CustomPostTypes Class
 *
 * This file contains the CustomPostTypes class which handles the registration
 * of custom post types for the Codehills Kickstarter theme. It includes methods
 * for creating custom post types, setting up their labels, and adding them to the
 * WordPress dashboard.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Create theme functions class
class CustomPostTypes {
    /**
     * Instance
     *
     * @since 2.0.0
     * @access private
     * @static
     *
     * @var Theme The single instance of the class.
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
     * @return Theme An instance of the class.
     */
    public static function instance() {
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
        // Change dashboard Posts to News
        add_filter( 'init', array( $this, 'codehills_change_post_object' ) );

        // Register Custom Post Type CustomCPT
        add_action( 'init', array( $this, 'codehills_create_custom_cpt' ), 0 );

        // Register Taxonomy CustomCPT Category
        add_action( 'init', array( $this, 'codehills_create_custom_tax' ) );
    }

    /**
     * Change dashboard Posts to News
     * 
     * @since 2.0.0
     * @access public
     */
    public function codehills_change_post_object()
    { 
        // Get post type
        $get_post_type = get_post_type_object( 'post' );

        // Get post type labels
        $labels = $get_post_type->labels;

        // Change labels
        $labels->name = 'News';
        $labels->singular_name = 'Article';
        $labels->add_new = 'Add Article';
        $labels->add_new_item = 'Add Article';
        $labels->edit_item = 'Edit Article';
        $labels->new_item = 'Article';
        $labels->view_item = 'View Article';
        $labels->search_items = 'Search News';
        $labels->not_found = 'No Articles found';
        $labels->not_found_in_trash = 'No Articles found in Trash';
        $labels->all_items = 'All Articles';
        $labels->menu_name = 'News';
        $labels->name_admin_bar = 'News';
    }

    /**
     * Register Custom Post Type CustomCPT
     * Post Type Key: custom
     * 
     * @since 2.0.0
     * @access public
     */
    public function codehills_create_custom_cpt()
    {
        // Get text domain
        $text_domain = ThemeFunctions::TEXT_DOMAIN;

        $labels = array(
            'name'                      => __( 'CustomCPT', $text_domain ),
            'singular_name'             => __( 'CustomCPT', $text_domain ),
            'menu_name'                 => __( 'CustomCPTs', $text_domain ),
            'name_admin_bar'            => __( 'CustomCPT', $text_domain ),
            'archives'                  => __( 'CustomCPT Archives', $text_domain ),
            'attributes'                => __( 'CustomCPT Attributes', $text_domain ),
            'parent_item_colon'         => __( 'Parent CustomCPT:', $text_domain ),
            'all_items'                 => __( 'All CustomCPTs', $text_domain ),
            'add_new_item'              => __( 'Add New CustomCPT', $text_domain ),
            'add_new'                   => __( 'Add New', $text_domain ),
            'new_item'                  => __( 'New CustomCPT', $text_domain ),
            'edit_item'                 => __( 'Edit CustomCPT', $text_domain ),
            'update_item'               => __( 'Update CustomCPT', $text_domain ),
            'view_item'                 => __( 'View CustomCPT', $text_domain ),
            'view_items'                => __( 'View CustomCPTs', $text_domain ),
            'search_items'              => __( 'Search CustomCPTs', $text_domain ),
            'not_found'                 => __( 'Not found', $text_domain ),
            'not_found_in_trash'        => __( 'Not found in Trash', $text_domain ),
            'featured_image'            => __( 'Featured Image', $text_domain ),
            'set_featured_image'        => __( 'Set featured image', $text_domain ),
            'remove_featured_image'     => __( 'Remove featured image', $text_domain ),
            'use_featured_image'        => __( 'Use as featured image', $text_domain ),
            'insert_into_item'          => __( 'Insert into CustomCPT', $text_domain ),
            'uploaded_to_this_item'     => __( 'Uploaded to this CustomCPT', $text_domain ),
            'items_list'                => __( 'CustomCPTs list', $text_domain ),
            'items_list_navigation'     => __( 'CustomCPTs list navigation', $text_domain ),
            'filter_items_list'         => __( 'Filter CustomCPT list', $text_domain ),
        );

        $args = array(
            'label'                     => __( 'CustomCPT', $text_domain ),
            'description'               => __( 'Codehills CustomCPTs', $text_domain ),
            'labels'                    => $labels,
            'menu_icon'                 => 'dashicons-image-filter',
            'supports'                  => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', ),
            'taxonomies'                => array(),
            'public'                    => true,
            'show_ui'                   => true,
            'show_in_menu'              => true,
            'menu_position'             => 5,
            'show_in_admin_bar'         => true,
            'show_in_nav_menus'         => true,
            'can_export'                => true,
            'has_archive'               => true,
            'hierarchical'              => false,
            'exclude_from_search'       => false,
            'show_in_rest'              => true,
            'publicly_queryable'        => true,
            'rewrite'    		        => array( 'slug' => 'custom', 'with_front' => false ),
            'capability_type'           => 'post',
        );

        register_post_type( 'custom', $args );
    }

    /**
     * Register Taxonomy CustomCPT Category
     * 
     * @since 2.0.0
     * @access public
     */
    public function codehills_create_custom_tax()
    {
        // Get text domain
        $text_domain = ThemeFunctions::TEXT_DOMAIN;
        
        $labels = array(
            'name'              => _x( 'CustomCPT Categories', 'taxonomy general name', $text_domain ),
            'singular_name'     => _x( 'CustomCPT Category', 'taxonomy singular name', $text_domain ),
            'search_items'      => __( 'Search CustomCPT Categories', $text_domain ),
            'all_items'         => __( 'All CustomCPT Categories', $text_domain ),
            'parent_item'       => __( 'Parent CustomCPT Category', $text_domain ),
            'parent_item_colon' => __( 'Parent CustomCPT Category:', $text_domain ),
            'edit_item'         => __( 'Edit CustomCPT Category', $text_domain ),
            'update_item'       => __( 'Update CustomCPT Category', $text_domain ),
            'add_new_item'      => __( 'Add New CustomCPT Category', $text_domain ),
            'new_item_name'     => __( 'New CustomCPT Category Name', $text_domain ),
            'menu_name'         => __( 'Categories', $text_domain ),
        );
        
        $args = array(
            'labels'                => $labels,
            'description'           => __( 'CustomCPT Categories', $text_domain ),
            'hierarchical'          => true,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
            'show_tagcloud'         => true,
            'show_in_quick_edit'    => true,
            'show_admin_column'     => true,
            'show_in_rest'          => true,
        );

        register_taxonomy( 'custom-category', array( 'custom' ), $args );
    }
}