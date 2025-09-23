<?php
/**
 * Content Media Grid Block
 *
 * This file is responsible for rendering the content media grid section of the website.
 * It retrieves the necessary content and settings from the WordPress backend
 * and displays them in a styled grid layout.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

use CodehillsKickstarter\Core\Builder;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get block global settings
$block_global_settings = $args['block_global_settings'];

// Get block details
$block_details = $args['block_details']; ?>

    <div class="content-media-block <?php echo ( $block_details->media['media_type'] == 'icon' || $block_details->viewport_height ) ? 'content-media-viewport-height' : ''; ?> <?php echo ( $block_details->media['media_type'] == 'icon' ) ? 'content-media-icon' : ''; ?>">
        <?php
            if( $block_details->fullwidth ) :
                // Image
                if( $block_details->media['media_type'] == 'image' && isset( $block_details->media['image'] ) && $block_details->media['image'] ):
                    echo '<div class="cover-image ' . ( $block_details->viewport_height ? 'viewport-height' : '' ) . ' uk-position-' . ( $block_details->layout == 'default' ? 'right' : 'left' ) . ' uk-position-z-index uk-width-' . $block_details->media_column_width . '@m uk-height-1-1 uk-visible@m" style="background-image: url(' . esc_url( $block_details->media['image']['url'] ) . ');"></div>';
                endif;

                // Icon
                if( $block_details->media['media_type'] == 'icon' && isset( $block_details->media['icon'] ) && $block_details->media['icon'] ):
                    echo '<div class="content-media-icon-wrapper uk-width-' . $block_details->media_column_width . '@m ' . ( $block_details->viewport_height ? 'viewport-height' : '' ) . ' uk-position-' . ( $block_details->layout == 'default' ? 'right' : 'left' ) . ' uk-flex uk-flex-center uk-flex-middle"';

                    if( ! empty( $block_details->media['icon_background'] ) ) {
                        echo ' style="background-color: ' . esc_attr( $block_details->media['icon_background'] ) . ';"';
                    }

                    echo '>';
                    echo '<img class="uk-preserve" src="' . esc_url( $block_details->media['icon']['url'] ) . '" alt="' . esc_attr( $block_details->media['icon']['alt'] ) . '" width="' . esc_attr( $block_details->media['icon']['width'] ) . '" height="' . esc_attr( $block_details->media['icon']['height'] ) . '" uk-svg>';
                    echo '</div>';
                endif;
            endif;
        ?>

        <div class="uk-container">
            <?php
                // Title / content grid
                if( ! empty( $block_global_settings->block_titles ) && ( $block_details->title_position == 'top' || $block_details->title_position == 'top-fullwidth') ) :
                    echo '<div class="uk-margin-large-bottom">';

                    if( $block_details->title_position == 'top' ) :
                        // You may need to implement this partial in PHP if not already available
                        get_template_part( 'views/builder/partials/php/title-content-grid', null, array(
                            'block_details' => $block_details,
                            'title_content' => ! empty( $block_details->title_content ) ? $block_details->title_content : ''
                        ));
                    elseif( $block_details->title_position == 'top-fullwidth' ) :
                        get_template_part( 'views/builder/partials/php/block-titles', null, array(
                            'block_global_settings' => $block_global_settings
                        ));
                    endif;

                    echo '</div>';
                endif;
            ?>

            <div class="content-block">
                <div class="<?php echo $block_details->viewport_height ? 'viewport-height' : ''; ?> uk-grid-<?php echo esc_attr( $block_details->columns_gap ); ?> <?php echo $block_details->vertical_align !== null ? 'uk-flex-' . esc_attr( $block_details->vertical_align ) : ''; ?> uk-grid-match" uk-grid>
                    <div class="uk-width-<?php echo esc_attr( $block_details->media_column_width ); ?>@m uk-position-relative">
                        <?php
                            // Titles
                            if( $block_details->title_position == 'media' ) :
                                get_template_part( 'views/builder/partials/php/block-titles', null, array(
                                    'block_global_settings' => $block_global_settings
                                ) );
                            endif;

                            // Media types
                            if( ! $block_details->fullwidth ) :
                                echo '<div class="uk-text-center uk-visible@m">';

                                // You may need to implement this partial in PHP if not already available
                                get_template_part( 'views/builder/partials/php/media-types', null, array(
                                    'block_details' => $block_details
                                ) );

                                echo '</div>';
                            endif;
                        ?>
                    </div>

                    <div class="uk-width-expand@m <?php echo $block_details->layout == 'default' ? 'uk-flex-first@m' : ''; ?> uk-text-<?php echo esc_attr( $block_details->content['text_align'] ); ?>">
                        <?php
                            // Separator
                            if( $block_details->media['media_type'] == 'icon' ) :
                                echo '<hr class="uk-invisible uk-margin-xlarge-top uk-margin-large-bottom uk-hidden@m">';
                            endif;

                            if( $block_details->columns_gap == 'collapse' ) :
                                echo '<div class="uk-panel uk-panel-large uk-flex uk-flex-middle"><div>';
                            endif;

                            // Titles
                            if( $block_details->title_position == 'content' ) :
                                get_template_part('views/builder/partials/php/block-titles', null, array(
                                    'block_global_settings' => $block_global_settings
                                ));
                            endif;

                            // Content
                            if( ! empty( $block_details->content['content'] ) ) :
                                echo '<div>' . $block_details->content['content'] . '</div>';
                            endif;

                            // CTA button
                            if( ! empty( $block_global_settings->have_cta ) ) :
                                echo '<div class="uk-child-width-auto@s uk-flex-' . esc_attr( $block_details->content['text_align'] ) . ' uk-margin-top uk-grid-small" uk-grid>';

                                Builder::get_ctas( $block_global_settings->have_cta );

                                echo '</div>';
                            endif;

                            if( $block_details->columns_gap == 'collapse' ) :
                                echo '</div></div>';
                            endif;

                            // Separator
                            if( $block_details->media['media_type'] == 'icon' ) :
                                echo '<hr class="uk-invisible uk-margin-xlarge-top uk-margin-large-bottom uk-hidden@s">';
                            else :
                                echo '<hr class="uk-invisible uk-hidden@m">';
                            endif;
                        ?>
                    </div>
                </div>
            </div>

            <?php
                // Media types (mobile)
                echo '<div class="uk-hidden@m">';

                // You may need to implement this partial in PHP if not already available
                get_template_part( 'views/builder/partials/php/media-types', null, array(
                    'block_details' => $block_details
                ) );

                echo '</div>';
            ?>
        </div>
    </div>
</section> <!-- Content Media Grid block end -->