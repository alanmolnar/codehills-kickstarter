<?php
/**
 * New block class pattern
 *
 * This file is responsible for creating a new block class pattern in the Codehills Kickstarter theme.
 * It retrieves necessary information from the console input to generate the block class.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Get the class name from the console input
$class_name = $args['class_name'];

// Get the class unique id from the console input
$class_unique_id = $args['class_unique_id'];

// Get the class filename from the console input
$class_filename = $args['class_filename'];

// Get the block name from the console input
$block_name = $args['block_name'];

echo '<?php
/**
 * ' . $class_name . ' Class
 *
 * This file contains the ' . $class_name . ' class which handles the rendering of the ' . strtolower( $block_name ) . ' section
 * for the Codehills Kickstarter theme. It includes methods for retrieving content and settings
 * from the WordPress backend and displaying them in a container.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Builder;

use CodehillsKickstarter\Core\Builder;
use CodehillsKickstarter\Helpers\Helpers;

class ' . $class_name . ' extends Builder
{    
    /**
     * The ACF flexible layout\'s unique identifier
     *
     * @var string
     */
    protected static $id = \'' . $class_unique_id . '\';

    /**
     * The layout\'s filename
     *
     * @var string
     */
    protected static $filename = \'' . $class_filename . '\';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = \'' . $block_name . '\';

    /**
     * Prepare the block data and render the block
     * 
     * @since 2.0.0
     * @access public
     * @return view
     */
    public static function render( $args = null )
    {
        // Get page id
        $page_id = get_the_ID();

        // Do action from Builder class
        Builder::page_builder_block_start( $page_id );

        // Block global settings
        $block_global_settings = Builder::get_block_global_settings( $page_id, $args, self::$id );

        // Block content
        $content = get_sub_field( \'content\' );
        
        // Set block details
        $block_details = Helpers::collect( [
            \'content\' => $content
        ] );

        // Render the block
        get_template_part( \'views/builder/blocks/\' . self::$filename, null, array(
            \'page_id\'               => $page_id,
            \'block_global_settings\' => $block_global_settings,
            \'block_details\'         => $block_details
        ) );
    }
}';