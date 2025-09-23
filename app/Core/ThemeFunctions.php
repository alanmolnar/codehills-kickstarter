<?php
/**
 * ThemeFunctions Class
 *
 * This file contains the ThemeFunctions class which handles the main functions
 * for the Codehills Kickstarter theme. This class is used to define the main
 * functions for the theme.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

use WP_Query;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Create theme functions class
class ThemeFunctions {
    /**
     * Instance
     *
     * @since 2.0.0
     * @access private
     * @static
     *
     * @var ThemeFunctions The single instance of the class.
     */
    private static $instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 2.0.0
     * @access public
     *
     * @return ThemeFunctions An instance of the class.
     */
    public static function instance()
    {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     * Theme constants
     *
     * Register theme functions class constants
     *
     * @since 2.0.0
     * @access public
     */

     // Text domain constant
    const TEXT_DOMAIN = 'codehills-kickstarter';

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
        // Page Slug Body Class
        add_filter( 'body_class', array( $this, 'add_slug_body_class' ) );

        // Remove default image sizes
        add_filter( 'intermediate_image_sizes_advanced', array( $this, 'remove_theme_default_image_sizes' ) );

        // Set excerpt length
        add_filter( 'excerpt_length', array( $this, 'theme_excerpt_length' ) );

        // Set three dots on the end of excerpt content
        add_filter( 'excerpt_more', array( $this, 'theme_excerpt_more_end_dots' ) );

        // Reduce auto P tag in CF7
        add_filter('wpcf7_autop_or_not', '__return_false');

        // Validate email address in Contact Form 7
        add_filter( 'wpcf7_validate_email', array( $this, 'theme_wpcf7_custom_email_validation_filter' ), 10, 2 );
        add_filter( 'wpcf7_validate_email*', array( $this, 'theme_wpcf7_custom_email_validation_filter' ), 10, 2 );

        // Validate name in Contact Form 7
        add_filter( 'wpcf7_validate_text', array( $this, 'theme_wpcf7_custom_name_validation_filter' ), 20, 2 );
        add_filter( 'wpcf7_validate_text*', array( $this, 'theme_wpcf7_custom_name_validation_filter' ), 20, 2 );

        // Loadmore posts, ajax
        add_action( 'wp_ajax_loadmore', array( $this, 'theme_loadmore_ajax_handler' ) );
        add_action( 'wp_ajax_nopriv_loadmore', array( $this, 'theme_loadmore_ajax_handler' ) );
    }

    /**
     * Check if Twig is enabled
     * 
     * Check if Twig is enabled in the theme settings
     * 
     * @since 2.1.0
     * @access public
     * @return bool True if Twig is enabled, false otherwise
     */
    public static function twig_enabled()
    {
        return get_field( 'enable_twig', 'option' );
    }

    /**
     * Add slug body class
     * 
     * Add slug body class to the body tag
     * 
     * @since 2.0.0
     * @access public
     * 
     * @param array $classes An array of body classes
     * @return array An array of body classes
     */
    public function add_slug_body_class( $classes )
    {
        // Define global variable
        global $post;

        // Update classes array
        if ( isset( $post ) ) :
            $classes[] = $post->post_type . '-' . $post->post_name;
        endif;

        return $classes;
    }

    /**
     * Remove theme default image sizes
     * 
     * Remove default image sizes from WordPress
     * 
     * @since 2.0.0
     * @access public
     * @param array $sizes An array of image sizes
     * @return array An array of image sizes
     */
    public function remove_theme_default_image_sizes( $sizes )
    {
        // Default WordPress
        unset( $sizes['thumbnail'] );       // Remove Thumbnail (150 x 150 hard cropped)
        unset( $sizes['medium'] );          // Remove Medium resolution (300 x 300 max height 300px)
        unset( $sizes['medium_large'] );    // Remove Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
        unset( $sizes['large'] );           // Remove Large resolution (1024 x 1024 max height 1024px)

        return $sizes;
    }

    /**
     * Set excerpt length
     * 
     * Set excerpt length for the theme
     * 
     * @since 2.0.0
     * @access public
     * @param int $length The length of the excerpt
     * @return int The length of the excerpt
     */
    public function theme_excerpt_length( $length )
    {
        // Define global variable
        global $post;

        return 9;
    }

    /**
     * Set three dots on the end of excerpt content
     * 
     * @since 2.0.0
     * @access public
     * @param string $more The excerpt more string
     * @return string The excerpt more string
     */
    public function theme_excerpt_more_end_dots( $more )
    {
        return '...';
    }

    /**
     * Custom theme excerpt with word trim
     * 
     * @since 2.0.0
     * @access public
     * @param string $content The content to be trimmed
     * @param int $count The number of words to trim
     * @return string The trimmed content
     */
    public static function theme_custom_excerpt( $content, $count )
    {
        // Trim content
        $excerpt = wp_trim_words( $content, $count );

        return $excerpt . '...';
    }

    /**
     * Get post reading time
     * 
     * Calculate the reading time of a post based on its content
     * 
     * @since 2.1.3
     * @access public
     * @param string $content The content of the post
     * @param string $string The string to append to the reading time (default: 'min read')
     * @return string The reading time in minutes with the appended string
     */
    public static function get_post_reading_time( $content, $string = 'min read' )
    {
        // Get content words
        $word_count = str_word_count( strip_tags( $content ) );

        // Words per minute
        $words_per_minute = 200;

        // Calculate reading time
        $minutes = floor( $word_count / $words_per_minute );

        // Return reading time
        return ( $minutes > 0 ? $minutes : 1 ) . ' ' . $string;
    }

    /**
     * Validate email address in Contact Form 7
     * 
     * @since 2.0.0
     * @access public
     * @param object $result The validation result
     * @param object $tag The form tag
     * @return object The validation result
     */
    public function theme_wpcf7_custom_email_validation_filter( $result, $tag )
    {
        // Get field name
        $name = $tag->name;

        if( isset( $_POST[$name] ) && $_POST[$name] != '' ) :
            // Get email
            $email = isset( $_POST[$name] ) ? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) ) : '';

            // Split out the local and domain parts.
            list( $local, $domain ) = explode( '@', $email, 2 );

            // LOCAL PART
            // Test for invalid characters.
            if ( ! preg_match( '/^[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]+$/', $local ) ) :
                /** This filter is documented in wp-includes/formatting.php */
                return $result->invalidate( $tag, wpcf7_get_message( 'invalid_email' ) );
            endif;

            // DOMAIN PART
            // Test for sequences of periods.
            if ( preg_match( '/\.{2,}/', $domain ) ) :
                return $result->invalidate( $tag, wpcf7_get_message( 'invalid_email' ) );
            endif;
        endif;

        return $result;
    }

    /**
     * Validate name in Contact Form 7
     * 
     * @since 2.0.0
     * @access public
     * @param object $result The validation result
     * @param object $tag The form tag
     * @return object The validation result
     */
    public function theme_wpcf7_custom_name_validation_filter( $result, $tag )
    {
        // Get field name
        $name = $tag->name;

        // Set field name
        $field_name = 'full-name';

        if( $field_name == $name ) :
            // Matches any utf words with the first not starting with a number or space break
            $regex = '/^(?![0-9\s])[\s\S]*$/';

            if( ! preg_match( $regex, $_POST[$field_name], $matches ) ) :
                $result->invalidate( $tag, 'This is not a valid name!' );
            endif;
        endif;

        return $result;
    }

    /**
     * Loadmore posts, ajax handler
     * 
     * @since 2.0.0
     * @access public
     * @return void
     */
    public function theme_loadmore_ajax_handler()
    {
        // Get the data parameters
        $page       = $_POST['page'] + 1;
        $max_page   = $_POST['max_page'];

        // Query arguments, show first 8 posts, then load more
        $args = array(
            'post_type'         => array( 'post' ),
            'posts_per_page'    => 8,
            'paged'             => $page,
            'orderby'           => 'date',
            'order'             => 'DESC'
        );

        // The Query
        $query = new WP_Query( $args );

        // Check if posts exist
        if( $query->have_posts() ) :
            // Set posts variable
            $posts = '';

            // Reset counter
            $counter = 1;

            // Start output buffering
            ob_start();

            // News loop
            while( $query->have_posts() ) :
                $query->the_post();
                
                // Get template part
                get_template_part( 'views/builder/partials/article-box', null, array(
                    'taxonomy'          => null,
                    'categories'        => null,
                    'thumbnail_size'    => 'full'
                ) );

                // Increment counter
                $counter++;
            endwhile;

            // End output buffering
            $posts = ob_get_clean();
        else:
            // Set posts to null
            $posts = null;
        endif;

        // Set response
        $response = [
            'posts'         => $posts,
            'page'          => $page,
            'no_more_posts' => $max_page == $page ? true : false,
        ];
        
        // Send response as JSON
        echo json_encode( $response );
    
        // End query
        die;
    }
}