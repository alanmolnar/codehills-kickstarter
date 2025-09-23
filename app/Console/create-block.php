<?php
/**
 * Create block command
 *
 * This file is responsible for setting up the environment to create a new block in the Codehills Kickstarter theme.
 * It includes necessary configurations and dependencies to ensure the proper functioning of the block creation process.
 *
 * The file performs the following tasks:
 * - Requires the wp-load.php file to use WordPress functions.
 * - Defines the directory for block classes.
 * - Defines the directory for block views.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Require wp-load.php to use WordPress functions
require_once dirname( __DIR__, 5 ) . '/wp-load.php';

// Define the block classes directory
$block_classes_dir = __DIR__ . '/../builder';

// Define the block views directory
$block_views_dir = __DIR__ . '/../../views/builder/blocks';

// Get class name from console input
echo "Enter block class name: ";

// Read class name from console input
$class_name = trim( fgets( STDIN ) );

// If input is empty or input have anything else except characters, output error message and exit
if ( empty( $class_name ) || !preg_match( '/^[a-zA-Z]+$/', $class_name ) ) :
    echo "Class name cannot be empty and must contain only letters!\n";
    exit;
endif;

// Define block class file name
$block_class_filename = "{$class_name}.php";

// Convert class name to lowercase and add hyphens between words which are separated by uppercase letter
$class_name_to_filename = strtolower( preg_replace( '/(?<!^)[A-Z]/', '-$0', $class_name ) );

// Convert class name to normal capitalize sentence
$block_name = ucwords( str_replace( '-', ' ', $class_name_to_filename ) );

// Define block view file name
$block_view_filename = "{$class_name_to_filename}.php";

// Check if class with that name already exist
if ( file_exists( "{$block_classes_dir}/{$block_class_filename}" ) ) :
    echo "Block class file '{$block_class_filename}' already exists!\n";
else:
    // Start buffer to capture output
    ob_start();

    // Predefined content for the PHP class
    get_template_part( 'app/Console/patterns/new-block-class', null, [
        'class_name'        => $class_name,
        'class_unique_id'   => str_replace( '-', '_', $class_name_to_filename ),
        'class_filename'    => $class_name_to_filename,
        'block_name'        => $block_name,
    ] );

    // Get the content from the buffer
    $block_class_content = ob_get_clean();

    // Write content to the file in the block classes directory
    file_put_contents( "{$block_classes_dir}/{$block_class_filename}", $block_class_content );

    // Output success message
    echo "Block class file '{$block_class_filename}' created successfully!\n";
endif;

// Check if view with that name already exist
if ( file_exists( "{$block_views_dir}/php/{$block_view_filename}" ) ) :
    echo "Block template file '{$block_view_filename}' already exists in views/builder/php folder!\n";
else:
    // Start buffer to capture output
    ob_start();

    // Predefined content for the PHP view
    get_template_part( 'app/Console/patterns/new-block-view', null, [
        'html_class_name'   => $class_name_to_filename,
        'block_name'        => $block_name
    ] );

    // Get the content from the buffer
    $block_view_content = ob_get_clean();

    // Write content to the file in the views builder directory
    file_put_contents( "{$block_views_dir}/php/{$block_view_filename}", $block_view_content );

    // Output success message
    echo "Block template file '{$block_view_filename}' created successfully in views/builder/php folder!\n";
endif;

// Define block view file name
$block_view_twig_filename = "{$class_name_to_filename}.twig";

// Check if Twig view with that name already exist
if ( file_exists( "{$block_views_dir}/twig/{$block_view_twig_filename}" ) ) :
    echo "Block template file '{$block_view_twig_filename}' already exists in views/builder/twig folder!\n";
else:
    // Start buffer to capture output
    ob_start();

    // Predefined content for the PHP view
    get_template_part( 'app/Console/patterns/new-block-view-twig', null, [
        'html_class_name'   => $class_name_to_filename,
        'block_name'        => $block_name
    ] );

    // Get the content from the buffer
    $block_view_twig_content = ob_get_clean();

    // Write content to the file in the views builder directory
    file_put_contents( "{$block_views_dir}/twig/{$block_view_twig_filename}", $block_view_twig_content );

    // Output success message
    echo "Block template file '{$block_view_twig_filename}' created successfully in views/builder/twig folder!\n";
endif;