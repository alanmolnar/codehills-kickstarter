<?php
/**
 * Block Notification Template Part
 *
 * This template displays a notification message prompting users that the page builder
 * doesn't have this block class. It is intended to be included in pages where the page
 * builder is be used and block that doesn't have assigned class is added.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\Core\Builder;
use CodehillsKickstarter\Core\ThemeFunctions;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit; ?>

<!-- Builder notification
============================================ -->
<section class="uk-section">
    <div class="uk-container">
        <?php
            // Title and subtitle
            get_template_part( 'views/builder/partials/php/block-titles', null, array(
                'block_global_settings' => $args['block_global_settings']
            ) );
        ?>

        <div class="uk-alert-danger" uk-alert>
            <p class="uk-text-large"><?php _e( 'This block doesn\'t have class and view assigned and can\'t be rendered. Please add class and view with <strong>\'php app/console/create-block.php\'</strong> command.', ThemeFunctions::TEXT_DOMAIN ); ?></p>
        </div>
    </div>
</section>