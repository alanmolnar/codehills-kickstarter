<?php
/**
 * Sidebar Template Part
 *
 * This file renders the sidebar content.
 * It is included in the article content template part when a sidebar is needed.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Render sidebar
echo $args['sidebar_content'];