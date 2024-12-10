/**
 * Main JavaScript File
 *
 * This file contains the main JavaScript code for the Codehills Kickstarter theme.
 * It includes jQuery scripts that run when the document is ready and after the page is fully loaded.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Theme scripts
jQuery( document ).ready( function($) {
    // jQuery code goes here
});

// Theme scripts after the page is loaded
jQuery( window ).on( 'load', function() {
    // Remove 'body' style attribute when the page is loaded
    $( 'body' ).removeAttr( 'style' );
});