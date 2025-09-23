<?php
/**
 * Codehills Studio 404 Page Template
 *
 * This template displays the 404 error page for the Codehills Kickstarter theme.
 * It retrieves custom fields for the title, content, and call-to-action (CTA) buttons
 * from the theme options and displays them. If no custom fields are set, it uses default values.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

use CodehillsKickstarter\Core\ThemeFunctions;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Include header
get_header();

// Get page details
$title          = get_field( '404_title', 'option' ) ? get_field( '404_title', 'option' ) : 'Error 404';
$content        = get_field( '404_content', 'option' ) ? get_field( '404_content', 'option' ) : __( 'Sorry, the page you are looking for has been moved or could not be found.', ThemeFunctions::TEXT_DOMAIN );
$cta_one_label  = get_field( '404_cta_one_label', 'option' ) ? get_field( '404_cta_one_label', 'option' ) : 'Go Back Home';
$cta_one_url    = get_field( '404_cta_one_url', 'option' ) ? get_field( '404_cta_one_url', 'option' ) : home_url();
$cta_two_label  = get_field( '404_cta_two_label', 'option' ) ? get_field( '404_cta_two_label', 'option' ) : '';
$cta_two_url    = get_field( '404_cta_two_url', 'option' ) ? get_field( '404_cta_two_url', 'option' ) : null;
$bg_image       = get_field( '404_background_image', 'option' ); ?>

<hr class="uk-margin-large-top uk-margin-bottom">

<!-- Main
============================================ -->
<section id="page404" class="transition uk-section" style="background-image: url(<?php echo $bg_image['url']; ?>);">
    <div class="uk-container">
        <div>
            <h1><?php echo $title; ?></h1>

            <p class="uk-text-large"><?php echo $content; ?></p>

            <?php
                // CTA buttons
                if ( ( $cta_one_label != '' && $cta_one_url != null ) || ( $cta_two_label != '' && $cta_two_url != null ) ) :
                    echo '<div class="uk-child-width-auto@s uk-margin-medium-top uk-grid-small" uk-grid>';
                endif;

                // CTA button one
                if ( $cta_one_label != '' && $cta_one_url != null ) :
                    get_template_part( 'views/template-parts/php/cta-button', null, array(
                        'cta_label'             => $cta_one_label,
                        'cta_url'               => $cta_one_url,
                        'cta_style'             => 'secondary',
                        'additional_classes'    => '',
                        'additional_attributes' => '',
                        'new_tab'               => false
                    ) );
                endif;

                // CTA button two
                if ( $cta_two_label != '' && $cta_two_url != null ) :
                    get_template_part( 'views/template-parts/php/cta-button', null, array(
                        'cta_label'             => $cta_two_label,
                        'cta_url'               => $cta_two_url,
                        'cta_style'             => 'outline',
                        'additional_classes'    => '',
                        'additional_attributes' => '',
                        'new_tab'               => false
                    ) );
                endif;

                // Close CTA buttons
                if ( ( $cta_one_label != '' && $cta_one_url != null ) || ( $cta_two_label != '' && $cta_two_url != null ) ) :
                    echo '</div>';
                endif;
            ?>
        </div>
    </div>
</section> <!-- #main end -->

<hr class="uk-margin-large-top uk-margin-large-bottom">

<?php
    // Include footer
    get_footer();
?>