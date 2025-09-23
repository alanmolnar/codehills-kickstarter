<?php
/**
 * Media Block
 *
 * This file is responsible for rendering the block section of the website.
 * It retrieves the necessary content and settings from the WordPress backend
 * and displays them in a container.
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

    <div class="media-block">
        <?php
            // Open container
            if( ! $block_details->fullwidth ) :
                echo '<div class="uk-container">';
            endif;

            // Title and subtitle
            get_template_part( 'views/builder/partials/php/block-titles', null, array(
                'block_global_settings' => $block_global_settings
            ) );

            echo '<div class="uk-margin-top">';

            // Image
            if( $block_details->media_type == 'image' && isset( $block_details->image ) && $block_details->image ) :
                echo '<img src="' . esc_url( $block_details->image['url'] ) . '" alt="' . esc_attr( $block_details->image['alt'] ) . '">';
            endif;

            // Video - MP4
            if( $block_details->media_type == 'mp4' && isset( $block_details->mp4_video ) && $block_details->mp4_video ) :
                echo '<video src="' . esc_url( $block_details->mp4_video['url'] ) . '" width="1920" height="1080" controls playsinline hidden uk-video></video>';
            endif;

            // Video - YouTube
            if( $block_details->media_type == 'youtube' && $block_details->youtube_video_id != '' ) :
                echo '<iframe src="https://www.youtube-nocookie.com/embed/' . esc_attr( $block_details->youtube_video_id ) . '?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1" width="1920" height="1080" allowfullscreen uk-responsive uk-video="automute: true;"></iframe>';
            endif;

            // Video - Vimeo
            if( $block_details->media_type == 'vimeo' && $block_details->vimeo_video_id != '' ) :
                echo '<iframe src="https://player.vimeo.com/video/' . esc_attr( $block_details->vimeo_video_id ) . '?badge=0&amp;autopause=0&amp;player_id=0&amp;" width="1920" height="1080" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" uk-responsive uk-video="automute: true"></iframe>';
            endif;

            echo '</div>';

            // CTA button
            if( $block_global_settings->have_cta ) :
                echo '<div class="uk-child-width-auto@s uk-margin-medium-top uk-grid-small" uk-grid>';

                // Loop through CTAs
                Builder::get_ctas( $block_global_settings->have_cta );

                echo '</div>';
            endif;

            // Close container
            if( ! $block_details->fullwidth ) :
                echo '</div>';
            endif;
        ?>
    </div>
</section> <!-- Media block end -->