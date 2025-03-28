<?php
/**
 * Create taxonomy command
 *
 * This file is responsible for setting up the environment to create a new taxonomy in the Codehills Kickstarter theme.
 * It includes necessary configurations and dependencies to ensure the proper functioning of the taxonomy creation process.
 *
 * The file performs the following tasks:
 * - Requires the wp-load.php file to use WordPress functions.
 * - Defines the directory for taxonomy classes.
 * - Prompts the user to enter the taxonomy class name via console input.
 *
 * @since 2.0.1
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Require wp-load.php to use WordPress functions
require_once dirname( __DIR__, 5 ) . '/wp-load.php';

// Define the taxonomy classes directory
$taxonomy_classes_dir = __DIR__ . '/../taxonomy';

// Get class name from console input
echo "Enter taxonomy class name: ";

// Read class name from console input
$class_name = trim( fgets( STDIN ) );

// If input is empty or input have anything else except characters, output error message and exit
if ( empty( $class_name ) || !preg_match( '/^[a-zA-Z]+$/', $class_name ) ) :
    echo "Class name cannot be empty!\n";
    exit;
endif;

// Get post type from console input
echo "Enter post type id: ";

// Read class name from console input
$post_type = trim( fgets( STDIN ) );

// If input is empty or post type doesn't exist, output error message and exit
if ( empty( $post_type ) || ! post_type_exists( $post_type ) ) :
    echo "Post type with id '{$post_type}' doesn't exist!\n";
    exit;
endif;

// Get taxonomy description from console input
echo "Enter taxonomy description: ";

// Read taxonomy description from console input
$taxonomy_description = trim( fgets( STDIN ) );

// Define taxonomy class file name
$taxonomy_class_filename = "{$class_name}.php";

// Convert class name to lowercase and add hyphens between words which are separated by uppercase letter
$taxonomy_unique_id = strtolower( preg_replace( '/(?<!^)[A-Z]/', '-$0', $class_name ) );

// Convert class name to normal capitalize sentence and use for the taxonomy singular name
$taxonomy_singular = ucwords( str_replace( '-', ' ', $taxonomy_unique_id ) );

// Create plural form of the taxonomy name
$taxonomy_plural = $taxonomy_singular . 's';

// Check if class with that name already exist
if ( file_exists( "{$taxonomy_classes_dir}/{$taxonomy_class_filename}" ) ) :
    echo "Taxonomy class file '{$taxonomy_class_filename}' already exists!\n";
else:
    // Start buffer to capture output
    ob_start();

    // Predefined content for the PHP class
    get_template_part( 'app/console/patterns/new-taxonomy-class', null, [
        'class_name'            => $class_name,
        'post_type'             => $post_type,
        'taxonomy_unique_id'    => $taxonomy_unique_id,
        'taxonomy_singular'     => $taxonomy_singular,
        'taxonomy_plural'       => $taxonomy_plural,
        'taxonomy_description'  => $taxonomy_description != null ? $taxonomy_description : $taxonomy_plural,
    ] );

    // Get the content from the buffer
    $taxonomy_class_content = ob_get_clean();

    // Write content to the file in the taxonomy classes directory
    file_put_contents( "{$taxonomy_classes_dir}/{$taxonomy_class_filename}", $taxonomy_class_content );

    // Output success message
    echo "Taxonomy class file '{$taxonomy_class_filename}' created successfully!\n";
endif;