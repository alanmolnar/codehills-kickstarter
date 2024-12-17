<?php
/**
 * New custom post type class pattern
 *
 * This file is responsible for creating a new custom post type class pattern in the Codehills Kickstarter theme.
 * It retrieves necessary information from the console input to generate the custom post type class.
 *
 * @since 2.0.1
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Get the class name from the console input
$class_name = $args['class_name'];

// Get the custom post type unique id from the console input
$cpt_unique_id = $args['cpt_unique_id'];

// Get the custom post type singular from the console input
$cpt_singular = $args['cpt_singular'];

// Get the custom post type plural from the console input
$cpt_plural= $args['cpt_plural'];

// Get the custom post type description from the console input
$cpt_description = $args['cpt_description'];

echo '<?php
/**
 * ' . $class_name . ' Class
 *
 * The ' . $class_name . ' class extends the CustomPostTypes class and provides specific functionality
 * for managing and displaying related content within the theme as custom post type.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\CPT;

use CodehillsKickstarter\Core\ThemeFunctions;
use CodehillsKickstarter\Core\CustomPostTypes;


class ' . $class_name . ' extends CustomPostTypes
{    
    /**
     * The custom post type unique identifier
     *
     * @var string
     */
    protected static $id = \'' . $cpt_unique_id . '\';

    /**
     * The custom post type singular
     *
     * @var string
     */
    protected static $singular = \'' . $cpt_singular . '\';

    /**
     * The custom post type plural
     *
     * @var string
     */
    protected static $plural = \'' . $cpt_plural . '\';

    /**
     * The custom post type description
     *
     * @var string
     */
    protected static $description = \'' . $cpt_description . '\';

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
        add_action( \'init\', array( $this, \'register_cpt\' ), 0 );
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
            \'name\'                      => __( self::$singular, $text_domain ),
            \'singular_name\'             => __( self::$singular, $text_domain ),
            \'menu_name\'                 => __( self::$plural, $text_domain ),
            \'name_admin_bar\'            => __( self::$singular, $text_domain ),
            \'archives\'                  => __( self::$singular . \' Archives\', $text_domain ),
            \'attributes\'                => __( self::$singular . \' Attributes\', $text_domain ),
            \'parent_item_colon\'         => __( \'Parent \' . self::$singular . \':\', $text_domain ),
            \'all_items\'                 => __( \'All \' . self::$plural, $text_domain ),
            \'add_new_item\'              => __( \'Add New \' . self::$singular, $text_domain ),
            \'add_new\'                   => __( \'Add New\', $text_domain ),
            \'new_item\'                  => __( \'New \' . self::$singular, $text_domain ),
            \'edit_item\'                 => __( \'Edit \' . self::$singular, $text_domain ),
            \'update_item\'               => __( \'Update \' . self::$singular, $text_domain ),
            \'view_item\'                 => __( \'View \' . self::$singular, $text_domain ),
            \'view_items\'                => __( \'View \' . self::$plural, $text_domain ),
            \'search_items\'              => __( \'Search \' . self::$plural, $text_domain ),
            \'not_found\'                 => __( \'Not found\', $text_domain ),
            \'not_found_in_trash\'        => __( \'Not found in Trash\', $text_domain ),
            \'featured_image\'            => __( \'Featured Image\', $text_domain ),
            \'set_featured_image\'        => __( \'Set featured image\', $text_domain ),
            \'remove_featured_image\'     => __( \'Remove featured image\', $text_domain ),
            \'use_featured_image\'        => __( \'Use as featured image\', $text_domain ),
            \'insert_into_item\'          => __( \'Insert into \' . self::$singular, $text_domain ),
            \'uploaded_to_this_item\'     => __( \'Uploaded to this \' . self::$singular, $text_domain ),
            \'items_list\'                => __( self::$plural . \' list\', $text_domain ),
            \'items_list_navigation\'     => __( self::$plural . \' list navigation\', $text_domain ),
            \'filter_items_list\'         => __( \'Filter \' . self::$singular . \' list\', $text_domain ),
        );

        $args = array(
            \'label\'                     => __( self::$singular, $text_domain ),
            \'description\'               => __( self::$description, $text_domain ),
            \'labels\'                    => $labels,
            \'menu_icon\'                 => \'dashicons-image-filter\',
            \'supports\'                  => array( \'title\', \'editor\', \'excerpt\', \'thumbnail\', \'revisions\', ),
            \'taxonomies\'                => array(),
            \'public\'                    => true,
            \'show_ui\'                   => true,
            \'show_in_menu\'              => true,
            \'menu_position\'             => 5,
            \'show_in_admin_bar\'         => true,
            \'show_in_nav_menus\'         => true,
            \'can_export\'                => true,
            \'has_archive\'               => true,
            \'hierarchical\'              => false,
            \'exclude_from_search\'       => false,
            \'show_in_rest\'              => true,
            \'publicly_queryable\'        => true,
            \'rewrite\'    		          => array( \'slug\' => self::$id, \'with_front\' => false ),
            \'capability_type\'           => \'post\',
        );

        register_post_type( self::$id, $args );
    }
}';