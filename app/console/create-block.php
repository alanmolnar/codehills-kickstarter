<?php
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
    get_template_part( 'app/console/patterns/new-block-class', null, [
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
if ( file_exists( "{$block_views_dir}/{$block_view_filename}" ) ) :
    echo "Block template file '{$block_view_filename}' already exists in views/builder folder!\n";
else:
    // Start buffer to capture output
    ob_start();

    // Predefined content for the PHP view
    get_template_part( 'app/console/patterns/new-block-view', null, [
        'html_class_name'   => $class_name_to_filename,
        'block_name'        => $block_name
    ] );

    // Get the content from the buffer
    $block_view_content = ob_get_clean();

    // Write content to the file in the views builder directory
    file_put_contents( "{$block_views_dir}/{$block_view_filename}", $block_view_content );

    // Output success message
    echo "Block template file '{$block_view_filename}' created successfully in views/builder folder!\n";
endif;

/**
 * Lines below are used to create a new block in the database
 * and add it to the ACF Flexible Content field, but they
 * are not working as expected with the clone fields.
 */

// $result = duplicate_acf_flexible_layout(
//     'field_6750876f5818e',  // Flexible field key
//     'default_layout',    // Name of the layout to duplicate
//     'klonirani_layout'   // Name for the duplicated layout
// );

// echo $result;

// This function needs work, test was successful with simple fields, but with clone fields it's not working as expected
function duplicate_acf_flexible_layout( $flexible_field_key, $layout_name_to_duplicate, $new_layout_name )
{
    // Load the field group containing the flexible content field
    $flexible_layout_field = acf_get_field( $flexible_field_key, true );

    // Get the field group and flexible layout field post IDs
    if ( $flexible_layout_field ) :
        echo 'Flexible Layout Key: ' . $flexible_field_key . "\n";

        // Get post ID where post name is equal to the flexible layout field key
        $flexible_layout_post = get_posts([
            'name'              => $flexible_field_key,
            'post_type'         => 'acf-field',
            'posts_per_page'    => 1
        ]);

        // Get the flexible layout post ID
        if ( ! empty( $flexible_layout_post ) ) :
            $flexible_layout_post = $flexible_layout_post[0];
            echo 'Flexible Layout Post ID: ' . $flexible_layout_post->ID . "\n";
        endif;

        // Get the parent key of the flexible layout field, usually a field group key
        $parent_key = $flexible_layout_field['parent'];

        echo 'Group Key: ' . $parent_key . "\n";
    
        // Get post ID where post name is equal to the field group key
        $group_post = get_page_by_path( $parent_key, OBJECT, 'acf-field-group' );

        if ( $group_post ) :
            echo 'Group Post ID: ' . $group_post->ID . "\n";
        endif;

        // Find the layout to duplicate
        $layouts = $flexible_layout_field['layouts'];

        // Initialize the layout to duplicate
        $layout_to_duplicate = null;

        // Find the layout to duplicate
        foreach ( $layouts as $layout ) :
            if ( $layout['name'] === $layout_name_to_duplicate ) :
                $layout_to_duplicate = $layout;
                break;
            endif;
        endforeach;

        // If the layout to duplicate is not found, return an error message
        if ( ! $layout_to_duplicate ) :
            return 'Error: Layout to duplicate not found.';
        endif;

        // Make the magic happen
        if( $group_post && $flexible_layout_post ) :
            // Generate a unique key for the new layout
            $layout_unique_key = 'layout_' . uniqid();

            // Create the new layout with a unique key and updated name
            $new_layout = $layout_to_duplicate;

            // Update the new layout attributes
            $new_layout['key']                              = $layout_unique_key;
            $new_layout['name']                             = $new_layout_name;
            $new_layout['label']                            = ucfirst(str_replace( '_', ' ', $new_layout_name ) );
            $new_layout['sub_fields'][0]['key']             = 'field_' . uniqid();
            $new_layout['sub_fields'][0]['parent_layout']   = $layout_unique_key;

            // Add the new layout to the Flexible Content field
            $flexible_layout_field['layouts'][$layout_unique_key] = $new_layout;

            // Add the flexible layout post ID to the flexible layout field
            $flexible_layout_field['ID'] = $flexible_layout_post->ID;

            // Save the updated Flexible Content field
            acf_update_field( $flexible_layout_field );

            // Save post parent ID meta value to the flexible layout field
            wp_update_post([
                'ID'            => $flexible_layout_post->ID,
                'post_parent'   => $group_post->ID
            ]);

            // Get the fields of the field group
            $fields = acf_get_fields( $group_post->ID );

            // Disable filters to ensure ACF loads data from DB.
			acf_disable_filters();

			// Get WordPress post from post ID
            $post = get_post( $group_post->ID, ARRAY_A );

			// Get fields before updating field group attributes.
			$fields = acf_get_fields( $post['ID'] );

            echo "Parent:\n";
            print_r($fields[0]['layouts'][$layout_unique_key]['sub_fields']);
            echo "\n";

            $new_post_id = 450;

			// // Update attributes.
			// $post['ID']  = $new_post_id;
			$post['key'] = uniqid( 'field_' );

			// Add (copy) to title when appropriate.
			$post['post_title'] .= ' (' . __( 'copy', 'acf' ) . ')';

			// When importing a new field group, insert a temporary post and set the field group's ID.
			// This allows fields to be updated before the field group (field group ID is needed for field parent setting).
            $post['ID'] = wp_insert_post( array(
                'post_name'     => uniqid( 'field_' ),
                'post_title'    => $post['post_title'],
                'post_parent'   => $flexible_layout_post->ID
            ) );

            // Get all sub_fields of the layout to duplicate
            $new_fields = $fields[0]['layouts'][$layout_unique_key]['sub_fields'];

            // Add the parent layout key to the new fields
            foreach( $new_fields as $field ) :
                $field['parent_layout'] = $layout_unique_key;
            endforeach;

			// Duplicate fields
			acf_duplicate_fields( $new_fields, $post['ID'] );

            // Update the post with the new fields
			$post = wp_update_post( $post );

            return 'Layout duplicated successfully!';
        endif;
    endif;

    // Check if the Flexible Content field exists and if not, return an error message
    if ( ! $flexible_layout_field || $flexible_layout_field['type'] !== 'flexible_content' ) :
        return 'Error: Flexible Content field not found.';
    endif;
}