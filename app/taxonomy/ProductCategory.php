<?php
/**
 * ProductCategory Class
 *
 * 
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Taxonomy;

use CodehillsKickstarter\Core\Taxonomies;
use CodehillsKickstarter\Core\ThemeFunctions;


class ProductCategory extends Taxonomies
{
    /**
     * Custom post type's unique identifier for taxonomy to be attached to
     *
     * @var string
     */
    protected static $post_type = 'product';

    /**
     * The custom taxonomy unique identifier
     *
     * @var string
     */
    protected static $id = 'product-category';

    /**
     * The custom taxonomy singular
     *
     * @var string
     */
    protected static $singular = 'Product Category';

    /**
     * Thecustom taxonomy plural
     *
     * @var string
     */
    protected static $plural = 'Product Categories';

    /**
     * The custom taxonomy description
     *
     * @var string
     */
    protected static $description = 'Galenika Product Categories';

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
        // Register custom taxonomy
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }

    /**
     * Register custom taxonomy
     * 
     * @since 2.0.0
     * @access public
     * @return view
     */
    public static function register_taxonomy()
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
            'menu_name'         => __( self::$plural, $text_domain ),
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

        register_taxonomy( 'product-category', array( 'product' ), $args );
    }
}