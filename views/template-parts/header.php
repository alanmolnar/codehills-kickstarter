<?php
/**
 * Header Template Part
 *
 * This template displays the site's header.
 * It contains site’s document type, meta information, links to stylesheets and scripts, and other data.
 *
 * @since 2.0.1
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\Core\UIKitMenuWalker;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit; ?>

<!DOCTYPE html>
<html <?php echo get_field( 'enable_preloader', 'option' ) ? 'class="preloader-active"' : ''; ?> <?php language_attributes(); ?>>
    <head profile="http://www.w3.org/1999/xhtml/vocab">
        <meta charset="<?php bloginfo( 'charset' ); ?>" />

        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta http-equiv="cleartype" content="on">

        <!-- Preconnect to Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <?php wp_head(); ?>
    </head>

    <?php
        // Get page settings
        $page_header_style          = get_field( 'page_header_style' ) || is_404() ? get_field( 'page_header_style' ) : 'light';
        $page_header_position       = get_field( 'page_header_position' ) || is_404() ? get_field( 'page_header_position' ) : 'absolute';
        $header_background_color    = get_field( 'header_background_color' ) ? get_field( 'header_background_color' ) : '';

        // Set page settings for single posts
        if( is_single() ) :
            $page_header_style      = 'dark';
            $page_header_position   = 'relative';
        endif;
    ?>

    <body <?php body_class(); ?> <?php echo get_field( 'enable_preloader', 'option' ) ? 'style="display: none;"' : ''; ?>>
        <!-- Header
        ============================================= -->
        <header class="header-<?php echo $page_header_style; ?> header-<?php echo $page_header_position; ?> transition" <?php echo $header_background_color != '' ? 'style="background-color: ' . $header_background_color . ';"' : ''; ?>>
            <div class="uk-container">
                <nav class="uk-navbar-container uk-navbar-transparent">
                    <div uk-navbar>
                        <div class="uk-navbar-left">
                            <?php
                                // Get site logo template part
                                get_template_part( 'views/template-parts/site-logo' );
                            ?>
                        </div>

                        <div class="uk-navbar-center">
                            <div class="uk-margin-medium-left uk-visible@m">
                                <?php 
                                    // Set 'items_wrap' parameter
                                    $items_wrap = '<ul class="uk-navbar-nav">%3$s</ul>';

                                    // Main navigation
                                    if( has_nav_menu( 'primary' ) ) :
                                        wp_nav_menu(array(
                                            'theme_location'    => 'primary',
                                            'walker'            => new UIKitMenuWalker(),
                                            'items_wrap'        => $items_wrap
                                        ));
                                    endif;
                                ?>
                            </div>
                        </div>

                        <div class="uk-navbar-right">
                            <a class="uk-navbar-toggle uk-navbar-toggle-animate uk-hidden@m" href="#offcanvas" uk-navbar-toggle-icon uk-toggle></a>
                        </div>
                    </div>
                </nav>
            </div>
        </header> <!-- Header end -->

        <?php
            // Mobile navigation
            get_template_part( 'views/template-parts/offcanvas' );
        ?>