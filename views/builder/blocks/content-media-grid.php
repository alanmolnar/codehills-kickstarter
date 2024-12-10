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

    <div class="content-media-block <?php echo $block_details->media['media_type'] == 'icon' || $block_details->viewport_height ? 'content-media-viewport-height' : ''; ?> <?php echo $block_details->media['media_type'] == 'icon' ? 'content-media-icon' : ''; ?>">
        <?php
            // Block image
            if( $block_details->fullwidth ):
                // Image
                if( $block_details->media['media_type'] == 'image' && isset( $block_details->media['image'] ) && $block_details->media['image'] ) :
                    echo '<div class="cover-image ' . ( $block_details->viewport_height ? 'viewport-height' : '' ) . ' uk-position-' . ( $block_details->layout == 'default' ? 'right' : 'left' ) . ' uk-position-z-index uk-width-' . $block_details->media_column_width . '@m uk-height-1-1 uk-visible@m" style="background-image: url(' . esc_url( $block_details->media['image']['url'] ) . ');"></div>';
                endif;

                // Icon
                if( $block_details->media['media_type'] == 'icon' && isset( $block_details->media['icon'] ) && $block_details->media['icon'] ) :
                    echo '<div class="content-media-icon-wrapper uk-width-' . $block_details->media_column_width . '@m ' . ( $block_details->viewport_height ? 'viewport-height' : '' ) . ' uk-position-' . ( $block_details->layout == 'default' ? 'right' : 'left' ) . ' uk-flex uk-flex-center uk-flex-middle" style="background-color: ' . $block_details->media['icon_background'] . ';">
                        <img class="uk-preserve" src="' . esc_url( $block_details->media['icon']['url'] ) . '" alt="' . esc_attr( $block_details->media['icon']['alt'] ) . '"  width="' . $block_details->media['icon']['width'] . '" height="' . $block_details->media['icon']['height'] . '" uk-svg>
                    </div>';
                endif;
            endif;
        ?>

        <div class="uk-container">
            <div class="content-block <?php echo $block_details->viewport_height ? 'viewport-height' : ''; ?> uk-grid-xlarge <?php echo $block_details->vertical_align != null ? 'uk-flex-' . $block_details->vertical_align : ''; ?>" uk-grid>
                <div class="uk-width-<?php echo $block_details->media_column_width; ?>@m uk-text-center uk-position-relative">
                    <?php
                        if( ! $block_details->fullwidth ) :
                            echo '<div>';

                            // Image
                            if( $block_details->media['media_type'] == 'image' && isset( $block_details->media['image'] ) && $block_details->media['image'] ) :
                                echo '<img class="uk-visible@m" src="' . esc_url( $block_details->media['image']['url'] ) . '" alt="' . esc_attr( $block_details->media['image']['alt'] ) . '">';
                            endif;

                            // Video - YouTube
                            if( $block_details->media['media_type'] == 'video' && $block_details->media['video_type'] == 'youtube' ) :
                                echo '<iframe class="uk-visible@m" src="https://www.youtube-nocookie.com/embed/' . esc_attr( $block_details->media['youtube_video_id'] ) . '?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1" width="1920" height="1080" allowfullscreen uk-responsive uk-video="automute: true"></iframe>';
                            endif;

                            // Video - MP4
                            if( $block_details->media['media_type'] == 'image' && $block_details->media['video_type'] == 'mp4' ) :
                                echo '<video class="uk-visible@m" src="' . esc_url( $block_details->media['mp4_video'] ) . '" width="1920" height="1080" controls playsinline hidden uk-video></video>';
                            endif;

                            echo '</div>';
                        endif;
                    ?>
                </div>

                <div class="uk-width-expand@m <?php echo $block_details->layout == 'default' ? 'uk-flex-first@m' : ''; ?> uk-text-<?php echo $block_details->content['text_align']; ?>">
                    <?php
                        // Separator
                        if( $block_details->media['media_type'] == 'icon' ) :
                            echo '<hr class="uk-invisible uk-margin-xlarge-top uk-margin-large-bottom uk-hidden@m">';
                        endif;

                        // Title and subtitle
                        get_template_part( 'views/builder/partials/block-titles', null, array(
                            'block_global_settings' => $block_global_settings
                        ) );

                        // Content
                        if( $block_details->content['content'] != '' ) :
                            echo '<div class="uk-margin-top">' . $block_details->content['content'] . '</div>';
                        endif;

                        // CTA button
                        if( $block_global_settings->have_cta ) :
                            echo '<div class="uk-child-width-auto@s uk-flex-' . $block_details->content['text_align'] . ' uk-margin-top uk-grid-small" uk-grid>';

                            // Loop through CTAs
                            Builder::get_ctas( $block_global_settings->have_cta );

                            echo '</div>';
                        endif;

                        // Separator
                        if( $block_details->media['media_type'] == 'icon' ) :
                            echo '<hr class="uk-invisible uk-margin-xlarge-top uk-margin-large-bottom uk-hidden@s">';
                        else:
                            echo '<hr class="uk-invisible uk-hidden@m">';
                        endif;
                    ?>
                </div>
            </div>

            <?php
                // Image
                if( $block_details->media['media_type'] == 'image' && isset( $block_details->media['image'] ) && $block_details->media['image'] ) :
                    echo '<img class="uk-hidden@m" src="' . esc_url( $block_details->media['image']['url'] ) . '" alt="' . esc_attr( $block_details->media['image']['alt'] ) . '"  width="' . $block_details->media['image']['width'] . '" height="' . $block_details->media['image']['height'] . '">';
                endif;

                // Video - YouTube
                if( $block_details->media['media_type'] == 'video' && $block_details->media['video_type'] == 'youtube' ) :
                    echo '<iframe class="uk-hidden@m" src="https://www.youtube-nocookie.com/embed/' . esc_attr( $block_details->media['youtube_video_id'] ) . '?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1" width="1920" height="1080" allowfullscreen uk-responsive uk-video="automute: true"></iframe>';
                endif;

                // Video - MP4
                if( $block_details->media['media_type'] == 'image' && $block_details->media['video_type'] == 'mp4' ) :
                    echo '<video class="uk-hidden@m" src="' . esc_url( $block_details->media['mp4_video'] ) . '" width="1920" height="1080" controls playsinline hidden uk-video></video>';
                endif;
            ?>
        </div>
    </div>
</section> <!-- Content Media Grid block end -->