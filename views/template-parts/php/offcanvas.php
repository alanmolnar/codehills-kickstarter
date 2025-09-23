<?php
/**
 * Offcanvas, Mobile Navigation Template Part
 *
 * This template part displays the offcanvas menu for mobile navigation. It includes
 * the site logo and the primary navigation menu. The offcanvas menu can be toggled
 * and supports overlay and flip options.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit; ?>

<!-- Offcanvas
============================================ -->
<div id="offcanvas" uk-offcanvas="mode: none; flip: true; overlay: true">
    <div class="uk-offcanvas-bar uk-offcanvas-menu-bar">
        <button class="uk-offcanvas-close uk-close-large" type="button" uk-close></button>

        <div class="uk-logo uk-flex uk-flex-center uk-margin-top">
            <?php
                // Get site logo template part
                get_template_part( 'views/template-parts/php/site-logo' );
            ?>
        </div>

        <div class="uk-margin-large-top uk-text-center">
            <?php 
                // Main navigation
                if( has_nav_menu( 'primary' ) ) :
                    wp_nav_menu(array(
                        'theme_location'    => 'primary',
                        'items_wrap'        => '<ul class="offcanvas-nav uk-nav">%3$s</ul>'
                    ));
                endif;
            ?>
        </div>
    </div>
</div>