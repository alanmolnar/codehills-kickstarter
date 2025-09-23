<?php
/**
 * Article Share Buttons Template Part
 *
 * This template part displays the share buttons for an article. It includes buttons for sharing
 * the article on social media platforms. This partial can be included in other templates to display
 * the share buttons for an article.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get post share details
$post_url   = esc_url( get_permalink( $post ) );
$post_title = esc_html( get_the_title( $post ) ); ?>

<ul class="article-share-buttons">
    <!-- Instagram (no direct sharing support) -->
    <li><a href="https://www.instagram.com/" uk-icon="icon: instagram" target="_blank" rel="noopener noreferrer"></a></li>

    <!-- X (Twitter) -->
    <li><a href="https://twitter.com/intent/tweet?url=<?php echo $post_url; ?>&text=<?php echo $post_title; ?>" uk-icon="icon: x" target="_blank" rel="noopener noreferrer"></a></li>

    <!-- Facebook -->
    <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" uk-icon="icon: facebook" target="_blank" rel="noopener noreferrer"></a></li>

    <!-- LinkedIn -->
    <li><a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $post_url; ?>" uk-icon="icon: linkedin" target="_blank" rel="noopener noreferrer"></a></li>
</ul>