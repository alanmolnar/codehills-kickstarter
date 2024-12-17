<?php
/**
 * Product Class
 *
 * The Product class extends the CustomPostTypes class and provides specific functionality
 * for managing and displaying product-related content within the theme as custom post type.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\CPT;

use CodehillsKickstarter\Core\ThemeFunctions;
use CodehillsKickstarter\Core\CustomPostTypes;


class Product extends CustomPostTypes
{    
    /**
     * The custom post type unique identifier
     *
     * @var string
     */
    protected static $id = 'product';

    /**
     * The custom post type singular
     *
     * @var string
     */
    protected static $singular = 'Product';

    /**
     * The custom post type plural
     *
     * @var string
     */
    protected static $plural = 'Products';

    /**
     * The custom post type description
     *
     * @var string
     */
    protected static $description = 'Galenika Products';

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
        // Register custom post type
        add_action( 'init', array( $this, 'register_cpt' ), 0 );
    }

    /**
     * Register custom post type
     * 
     * @since 2.0.0
     * @access public
     * @return view
     */
    public static function register_cpt()
    {
        // Get text domain
        $text_domain = ThemeFunctions::TEXT_DOMAIN;

        $labels = array(
            'name'                      => __( self::$singular, $text_domain ),
            'singular_name'             => __( self::$singular, $text_domain ),
            'menu_name'                 => __( self::$plural, $text_domain ),
            'name_admin_bar'            => __( self::$singular, $text_domain ),
            'archives'                  => __( self::$singular . ' Archives', $text_domain ),
            'attributes'                => __( self::$singular . ' Attributes', $text_domain ),
            'parent_item_colon'         => __( 'Parent ' . self::$singular . ':', $text_domain ),
            'all_items'                 => __( 'All ' . self::$plural, $text_domain ),
            'add_new_item'              => __( 'Add New ' . self::$singular, $text_domain ),
            'add_new'                   => __( 'Add New', $text_domain ),
            'new_item'                  => __( 'New ' . self::$singular, $text_domain ),
            'edit_item'                 => __( 'Edit ' . self::$singular, $text_domain ),
            'update_item'               => __( 'Update ' . self::$singular, $text_domain ),
            'view_item'                 => __( 'View ' . self::$singular, $text_domain ),
            'view_items'                => __( 'View ' . self::$plural, $text_domain ),
            'search_items'              => __( 'Search ' . self::$plural, $text_domain ),
            'not_found'                 => __( 'Not found', $text_domain ),
            'not_found_in_trash'        => __( 'Not found in Trash', $text_domain ),
            'featured_image'            => __( 'Featured Image', $text_domain ),
            'set_featured_image'        => __( 'Set featured image', $text_domain ),
            'remove_featured_image'     => __( 'Remove featured image', $text_domain ),
            'use_featured_image'        => __( 'Use as featured image', $text_domain ),
            'insert_into_item'          => __( 'Insert into ' . self::$singular, $text_domain ),
            'uploaded_to_this_item'     => __( 'Uploaded to this ' . self::$singular, $text_domain ),
            'items_list'                => __( self::$plural . ' list', $text_domain ),
            'items_list_navigation'     => __( self::$plural . ' list navigation', $text_domain ),
            'filter_items_list'         => __( 'Filter ' . self::$singular . ' list', $text_domain ),
        );

        $args = array(
            'label'                     => __( self::$singular, $text_domain ),
            'description'               => __( self::$description, $text_domain ),
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
            'rewrite'    		        => array( 'slug' => self::$id, 'with_front' => false ),
            'capability_type'           => 'post',
        );

        register_post_type( self::$id, $args );
    }
}