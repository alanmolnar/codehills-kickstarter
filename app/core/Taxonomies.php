<?php
/**
 * Taxonomies Class
 *
 * This file contains the Taxonomies class which handles the registration
 * of custom taxonomies for the Codehills Kickstarter theme. It includes methods
 * for creating custom taxonomies, setting up their labels, and adding them to the
 * WordPress dashboard.
 *
 * The Taxonomies class provides specific functionality for managing and displaying
 * taxonomy-related content within the theme. It ensures that the custom taxonomies
 * are registered and available for use with custom post types and other content types.
 *
 * @since 2.0.1
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Create theme functions class
class Taxonomies {
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

     private static $namespace_prefix = 'CodehillsKickstarter\\Taxonomy\\';

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
        // Initialize custom taxonomies
        $this->initialize_custom_taxonomies();
    }

   /**
     * Initialize custom taxonomies
     *
     * @since 2.0.0
     * @access private
     */
    private function initialize_custom_taxonomies()
    {
        // Instantiate all custom taxonomies from /app/taxonomy folder
        $custom_taxonomies = glob( get_template_directory() . '/app/taxonomy/*.php' );

        // Loop through taxonomies
        foreach( $custom_taxonomies as $taxonomy ) :
            // Get custom post type class name
            $custom_taxonomy_class_name = str_replace( ' ', '', ucwords( str_replace( '_', ' ', basename( $taxonomy, '.php' ) ) ) );

            // Create full path to class
            $custom_taxonomy_class_name = self::$namespace_prefix . $custom_taxonomy_class_name;

            // Check if class exists
            if ( class_exists( $custom_taxonomy_class_name ) && strpos( $custom_taxonomy_class_name, 'Index' ) === false ) :
                // Instantiate block class
                $taxonomy = new $custom_taxonomy_class_name();
            endif;
        endforeach;
    }
}