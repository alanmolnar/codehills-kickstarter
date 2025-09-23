<?php
/**
 * Media Types Template Part
 *
 * This template part displays the media types for a block. It retrieves the media type and
 * associated data from the block global settings and displays them with the specified HTML tags and styles.
 * This partial can be included in other templates to display block media.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

if( isset( $args['block_details'] ) && ! empty( $args['block_details'] ) ) :
    // Get block global details
    $block_details = $args['block_details'];

    // Get details
    $media_type         = $block_details->media['media_type'];
    $image              = $block_details->media['image'] ? $block_details->media['image'] : null;
    $gallery            = $block_details->media['gallery'] ? $block_details->media['gallery'] : null;
    $video_type         = $block_details->media['video_type'] ? $block_details->media['video_type'] : null;
    $youtube_video_id   = $block_details->media['youtube_video_id'] ? $block_details->media['youtube_video_id'] : null;
    $mp4_video          = $block_details->media['mp4_video'] ? $block_details->media['mp4_video'] : null;
endif;

// Image
if( isset( $media_type ) &&  $media_type === 'image' && ! empty( $image ) ) :
    echo '<img class="img-border-rounded" src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '">';
endif;

// Gallery
if( isset( $media_type ) && $media_type === 'gallery' && ! empty( $gallery ) ) :
    echo '<div class="splide splide-benefits-carousel uk-position-relative">';

    // Splide slider track
    get_template_part( 'views/builder/partials/php/splide-slider-carousel-track', null, array(
        'slides' => ! empty( $gallery ) ? $gallery : null
    ) );

    // Splide navigation / pagination
    echo '<div class="uk-position-bottom uk-margin-bottom">';

    // Get slider navigation / pagination partial
    get_template_part( 'views/builder/partials/php/splide-slider-navigation-pagination' );

    echo '</div></div>';
endif;

// Video - YouTube
if( isset( $media_type ) && $media_type === 'video' && isset( $video_type ) && $video_type === 'youtube' ) :
    echo '<iframe class="img-border-rounded" src="https://www.youtube-nocookie.com/embed/' . esc_attr( $youtube_video_id ) . '?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1" width="1920" height="1080" allowfullscreen uk-responsive uk-video="automute: true"></iframe>';
endif;

// Video - MP4
if( isset( $media_type ) && $media_type === 'video' && isset( $video_type ) && $video_type === 'mp4' ) :
    echo '<video class="img-border-rounded" src="' . esc_url( $mp4_video ) . '" width="1920" height="1080" controls playsinline hidden uk-video></video>';
endif; ?>