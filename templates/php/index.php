<?php
/**
 * Codehills Kickstarter Index Page Template
 *
 * This template is used as the default template if no other template files match a query.
 * It includes the main loop to display posts and uses the page builder function to render
 * the content of the current post.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\Core\Twig;
use CodehillsKickstarter\Core\ThemeFunctions;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Include header
get_header();

// Main Loop
get_template_part( 'views/template-parts/php/main-loop' );

// Include footer
get_footer();