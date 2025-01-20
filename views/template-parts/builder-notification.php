<?php
/**
 * Builder Notification Template Part
 *
 * This template displays a notification message prompting users to use the page builder
 * to add blocks to the page. It is intended to be included in pages where the page builder
 * should be used.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\Core\ThemeFunctions;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit; ?>

<!-- Builder notification
============================================ -->

<hr class="uk-margin-large-top uk-margin-bottom">

<section class="uk-section">
    <div class="uk-container">
        <h1><?php echo $args['title']; ?></h1>

        <p class="uk-text-large"><?php _e( 'Please use page builder to add blocks to the page.', ThemeFunctions::TEXT_DOMAIN ); ?></p>
    </div>
</section>

<hr class="uk-margin-large-top uk-margin-large-bottom">