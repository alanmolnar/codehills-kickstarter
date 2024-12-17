<?php
/**
 * New taxonomy class pattern
 *
 * This file is responsible for creating a new taxonomy class pattern in the Codehills Kickstarter theme.
 * It retrieves necessary information from the console input to generate the taxonomy class.
 *
 * @since 2.0.1
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Get the class name from the console input
$class_name = $args['class_name'];

// Get the post_type from the console input
$post_type = $args['post_type'];

// Get the taxonomy unique id from the console input
$taxonomy_unique_id = $args['taxonomy_unique_id'];

// Get the taxonomy singular from the console input
$taxonomy_singular = $args['taxonomy_singular'];

// Get the taxonomy plural from the console input
$taxonomy_plural= $args['taxonomy_plural'];

// Get the taxonomy description from the console input
$taxonomy_description = $args['taxonomy_description'];

echo '<?php
/**
 * ' . $class_name . ' Class
 *
 * This class defines a custom taxonomy for the ' . $post_type . ' custom post type.
 * It extends the Taxonomies class from the Codehills Kickstarter theme.
 * The custom taxonomy is identified by the unique identifier ' . $taxonomy_unique_id . '.
 *
 * The class provides functionality to register and manage the custom taxonomy
 * for the ' . $post_type . ' post type, allowing for better organization and categorization
 * of products within the WordPress site.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Taxonomy;

use CodehillsKickstarter\Core\Taxonomies;
use CodehillsKickstarter\Core\ThemeFunctions;


class ' . $class_name . ' extends Taxonomies
{    
    /**
     * Custom post type\'s unique identifier for taxonomy to be attached to
     *
     * @var string
     */
    protected static $post_type = \'' . $post_type . '\';

    /**
     * The taxonomy unique identifier
     *
     * @var string
     */
    protected static $id = \'' . $taxonomy_unique_id . '\';

    /**
     * The taxonomy singular
     *
     * @var string
     */
    protected static $singular = \'' . $taxonomy_singular . '\';

    /**
     * The taxonomy plural
     *
     * @var string
     */
    protected static $plural = \'' . $taxonomy_plural . '\';

    /**
     * The taxonomy description
     *
     * @var string
     */
    protected static $description = \'' . $taxonomy_description . '\';

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
        // Register taxonomy
        add_action( \'init\', array( $this, \'register_taxonomy\' ) );
    }

    /**
     * Register taxonomy
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
            \'name\'              => _x( self::$plural, \'taxonomy general name\', $text_domain ),
            \'singular_name\'     => _x( self::$singular, \'taxonomy singular name\', $text_domain ),
            \'search_items\'      => __( \'Search \' . self::$plural, $text_domain ),
            \'all_items\'         => __( \'All \' . self::$plural, $text_domain ),
            \'parent_item\'       => __( \'Parent \' . self::$singular, $text_domain ),
            \'parent_item_colon\' => __( \'Parent \' . self::$singular . \':\', $text_domain ),
            \'edit_item\'         => __( \'Edit \' . self::$singular, $text_domain ),
            \'update_item\'       => __( \'Update \' . self::$singular, $text_domain ),
            \'add_new_item\'      => __( \'Add New \' . self::$singular, $text_domain ),
            \'new_item_name\'     => __( \'New \' . self::$singular . \' Name\', $text_domain ),
            \'menu_name\'         => __( self::$plural, $text_domain ),
        );
        
        $args = array(
            \'labels\'                => $labels,
            \'description\'           => __( self::$description, $text_domain ),
            \'hierarchical\'          => true,
            \'public\'                => true,
            \'publicly_queryable\'    => true,
            \'show_ui\'               => true,
            \'show_in_menu\'          => true,
            \'show_in_nav_menus\'     => true,
            \'show_tagcloud\'         => true,
            \'show_in_quick_edit\'    => true,
            \'show_admin_column\'     => true,
            \'show_in_rest\'          => true,
        );

        register_taxonomy( self::$id, array( self::$post_type ), $args );
    }
}';