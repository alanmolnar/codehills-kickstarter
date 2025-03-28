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
     * Namespace prefix
     * 
     * @since 2.0.0
     * @access private
     * @var string The namespace prefix
     */

    private static $namespace_prefix = 'CodehillsKickstarter\\CPT\\';

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

        // Initialize custom post types
        $this->initialize_custom_post_types();
    }

    /**
     * Initialize custom post types
     *
     * @since 2.0.0
     * @access private
     */
    private function initialize_custom_post_types()
    {
        // Instantiate all custom post types from /app/cpt folder
        $custom_post_types = glob( get_template_directory() . '/app/CPT/*.php' );

        // Loop through custom_post_types
        foreach( $custom_post_types as $post_type ) :
            // Get custom post type class name
            $cpt_class_name = str_replace( ' ', '', ucwords( str_replace( '_', ' ', basename( $post_type, '.php' ) ) ) );

            // Create full path to class
            $cpt_class_name = self::$namespace_prefix . $cpt_class_name;

            // Check if class exists
            if ( class_exists( $cpt_class_name ) && strpos( $cpt_class_name, 'Index' ) === false ) :
                // Instantiate custom post type class
                $post_type = new $cpt_class_name();
            endif;
        endforeach;
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
}