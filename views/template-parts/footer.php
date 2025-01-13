<?php
/**
 * Footer Template Part
 *
 * This template displays the footer section of the Codehills Studio theme.
 * It includes the footer navigation menu and other footer content.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\Core\ThemeFunctions;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit; ?>

        <!-- Footer
        ============================================= -->
        <footer>
            <div class="uk-container">
                <h4><?php _e( 'Footer Nav', ThemeFunctions::TEXT_DOMAIN ); ?></h4>

                <?php
                    // Footer Navigation
                    if( has_nav_menu( 'footer_nav' ) ) :
                        wp_nav_menu( array(
                            'theme_location' => 'footer_nav',
                            'container'      => false,
                            'items_wrap'     => '<ul class="uk-nav uk-margin-top">%3$s</ul>',
                            'depth'          => 1
                        ));
                    endif;
                ?>
                
                <h4><?php _e( 'Connect', ThemeFunctions::TEXT_DOMAIN ); ?></h4>

                <?php
                    // Get template part for social links
                    get_template_part( 'views/template-parts/social-links' );
                ?>
            </div>
        </footer> <!-- Footer end -->

        <?php wp_footer(); ?>
    </body>
</html>