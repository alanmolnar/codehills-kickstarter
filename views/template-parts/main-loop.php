<?php
/**
 * Main Loop Template Part
 *
 * This template part handles the main loop of the WordPress theme. It iterates over
 * the posts and renders the content for each post. It includes the main structure
 * of the page and calls the page builder to render the content dynamically.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Main Loop
while( have_posts() ) : the_post(); ?>
    <!-- Main
    ============================================ -->
    <main id="main">
        <?php
            // Page builder
            Builder::page_builder( get_the_ID() );
        ?>
    </main> <!-- #main end -->
<?php endwhile;