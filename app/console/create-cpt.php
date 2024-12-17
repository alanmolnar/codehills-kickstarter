<?php
/**
 * Create custom post type command
 *
 * This file is responsible for setting up the environment to create a new custom post type in the Codehills Kickstarter theme.
 * It includes necessary configurations and dependencies to ensure the proper functioning of the custom post type creation process.
 *
 * The file performs the following tasks:
 * - Requires the wp-load.php file to use WordPress functions.
 * - Defines the directory for custom post type classes.
 * - Prompts the user to enter the custom post type class name via console input.
 *
 * @since 2.0.1
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Require wp-load.php to use WordPress functions
require_once dirname( __DIR__, 5 ) . '/wp-load.php';

// Define the custom post type classes directory
$cpt_classes_dir = __DIR__ . '/../cpt';

// Get class name from console input
echo "Enter custom post type class name: ";

// Read class name from console input
$class_name = trim( fgets( STDIN ) );

// If input is empty or input have anything else except characters, output error message and exit
if ( empty( $class_name ) || !preg_match( '/^[a-zA-Z]+$/', $class_name ) ) :
    echo "Class name cannot be empty!\n";
    exit;
endif;

// Get custom post type description from console input
echo "Enter custom post type description: ";

// Read custom post type description from console input
$cpt_description = trim( fgets( STDIN ) );

// Define custom post type class file name
$cpt_class_filename = "{$class_name}.php";

// Convert class name to lowercase and add hyphens between words which are separated by uppercase letter
$cpt_unique_id = strtolower( preg_replace( '/(?<!^)[A-Z]/', '-$0', $class_name ) );

// Convert class name to normal capitalize sentence and use for the custom post type singular name
$cpt_singular = ucwords( str_replace( '-', ' ', $cpt_unique_id ) );

// Create plural form of the custom post type name
$cpt_plural = $cpt_singular . 's';

// Check if class with that name already exist
if ( file_exists( "{$cpt_classes_dir}/{$cpt_class_filename}" ) ) :
    echo "Custom post type class file '{$cpt_class_filename}' already exists!\n";
else:
    // Start buffer to capture output
    ob_start();

    // Predefined content for the PHP class
    get_template_part( 'app/console/patterns/new-cpt-class', null, [
        'class_name'        => $class_name,
        'cpt_unique_id'     => $cpt_unique_id,
        'cpt_singular'      => $cpt_singular,
        'cpt_plural'        => $cpt_plural,
        'cpt_description'   => $cpt_description != null ? $cpt_description : $cpt_plural,
    ] );

    // Get the content from the buffer
    $cpt_class_content = ob_get_clean();

    // Write content to the file in the custom post type classes directory
    file_put_contents( "{$cpt_classes_dir}/{$cpt_class_filename}", $cpt_class_content );

    // Output success message
    echo "Custom post type class file '{$cpt_class_filename}' created successfully!\n";
endif;