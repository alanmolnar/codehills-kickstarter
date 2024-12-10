<?php
/**
 * Codehills Kickstarter theme functions and definitions
 *
 * This file contains the main functions and definitions for the Codehills Kickstarter theme.
 * It includes the autoloader function, registers the autoloader, and initializes the theme setup.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\ThemeSetup;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

/**
 * Autoload function
 * 
 * This function autoloads classes from the '/app' directory.
 * 
 * @since 2.0.0
 * @param string $class_name The name of the class to autoload
 */
if ( ! function_exists( 'codehills_kickstarter_theme_autoLoader' ) ) :
    function codehills_kickstarter_theme_autoLoader( $class_name )
    {
        // Namespace prefix
        $prefix = 'CodehillsKickstarter\\';

        // Only autoload classes that begin with the namespace prefix
        if ( 0 !== strpos( $class_name, $prefix ) ) :
            return;
        endif;

        // Replace namespace backslashes with directory separators
        $class_name = str_replace( $prefix, '', $class_name );
        $class_name = str_replace( '\\', DIRECTORY_SEPARATOR, $class_name );

        $file = get_template_directory() . '/app/' . $class_name . '.php';

        // If the file exists, include it
        if ( file_exists( $file ) ) :
            require_once $file;
        endif;
    }
endif;

/**
 * Register autoloader
 * 
 * Register the autoloader function to autoload classes from the '/app' directory.
 * 
 * @since 2.0.0
 * @uses codehills_kickstarter_theme_autoLoader()
 * @link https://www.php.net/manual/en/function.spl-autoload-register.php
 */
spl_autoload_register( 'codehills_kickstarter_theme_autoLoader' );

/**
 * Theme setup
 * 
 * Initialize the theme setup process.
 * 
 * @since 2.0.0
 * @uses ThemeSetup
 * @link https://developer.wordpress.org/reference/functions/add_action/
 * @link https://developer.wordpress.org/reference/functions/after_setup_theme/
 * @link https://developer.wordpress.org/reference/functions/get_template_directory/
 * @link https://developer.wordpress.org/reference/functions/require_once/
 */
if ( ! function_exists( 'codehills_theme_setup' ) ) :
    function codehills_theme_setup()
    {
        // Call TGM Plugin Activation
        require_once get_template_directory() . '/app/libs/tgm-plugin/class-tgm-plugin-activation.php';

        // Instantiate ThemeSetup class
        $theme_setup = new ThemeSetup();

        // Initialize the theme setup
        $theme_setup->init();
    }
    add_action( 'after_setup_theme', 'codehills_theme_setup' );
endif;

/**
 * Debug function
 * 
 * This function is a helper function to debug variables. that dump and die,
 * taken from Laravel ecosystem and customized for WordPress.
 * 
 * @since 2.0.0
 * @param mixed $vars The variables to debug
 * @link https://laravel.com/docs/8.x/helpers#method-dd
 */
if ( ! function_exists( 'dd' ) ) :
    function dd( ...$vars )
    {
        // Add the javascript that toggles the debug output
        echo '<script type="text/javascript">
            // Add event listener for the check if DOM is loaded
            document.addEventListener( \'DOMContentLoaded\', function() {
                // Get all elements with class \'dd-toggle\' and loop through them
                document.querySelectorAll( \'.dd-toggle\' ).forEach( function( toggle ) {
                    // Add click event listener to each element
                    toggle.addEventListener( \'click\', function() {
                        console.log( \'Clicked!\' );
                        // Get the next sibling element
                        var target = this.nextElementSibling;

                        // Toggle the \'uk-hidden\' class
                        target.classList.toggle( \'uk-hidden\' );

                        // Change the text content of the element
                        if ( target.classList.contains( \'uk-hidden\' ) ) {
                            this.textContent = \'⯈\';
                        } else {
                            this.textContent = \'⯆\';
                        }
                    });
                });
            });
        </script>';

        // Loop through the variables
        foreach ( $vars as $var ) :
            echo '<div class="dd-debug">';

            // Render the variables
            render_debug_variable( $var );

            echo '</div>';
        endforeach;

        // Die after rendering the variables
        die;
    }
endif;

/**
 * Recursive function to render debug variables.
 *
 * @param mixed $var The variable to render.
 * @return void
 */
if ( ! function_exists( 'render_debug_variable' ) ) :
    function render_debug_variable( $var )
    {
        // Render array if it has more than one element
        if ( is_array( $var ) ) :
            // Add toggle if array has more than one element
            if ( count( $var ) > 1 ) : ?>
                <span class="dd-toggle">⯈</span>
                
                <div class="uk-hidden">
                    <?php echo 'Array (' . count( $var ) . ')';
            endif; ?>

            <ul>
                <?php
                    // Loop through the array
                    foreach ( $var as $key => $value ) :
                        echo '<li><strong>' . htmlspecialchars( ( string ) $key ) . '</strong>: ';

                        // Recursively render subarrays
                        render_debug_variable( $value );

                        echo '</li>';
                    endforeach;
                ?>
            </ul>

            <?php
                // Close the div if array has more than one element
                if ( count( $var ) > 1 ) :
                    echo '</div>';
                endif;
        // Render object if it has more than one property
        elseif ( is_object( $var ) ) :
            // Add toggle if object has more than one property
            if ( count( get_object_vars( $var ) ) > 1 ) : ?>
                <span class="dd-toggle">⯈</span>
                
                <div class="uk-hidden">
                    <?php echo 'Object (' . count( get_object_vars( $var ) ) . ')';
                endif;
            ?>

            <ul>
                <?php
                    // Loop through the object
                    foreach ( get_object_vars( $var ) as $key => $value ) :
                        echo '<li><strong>' . htmlspecialchars( ( string ) $key ) . '</strong>: ';

                        // Recursively render subarrays
                        render_debug_variable( $value );

                        echo '</li>';
                    endforeach;
                ?>
            </ul>

            <?php
                // Close the div if object has more than one property
                if ( count( get_object_vars( $var ) ) > 1 ) :
                    echo '</div>';
                endif;
        else:
            // Render the string
            echo htmlspecialchars( ( string ) $var );
        endif;
    }
endif;