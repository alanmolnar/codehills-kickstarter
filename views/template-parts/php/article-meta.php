<?php
/**
 * Article Meta Template Part
 *
 * This template part displays the meta information of an article. It includes the article author,
 * publication date, and categories. This partial can be included in other templates to display
 * the meta information of an article.
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit; ?>

<div class="article-meta-grid uk-flex uk-flex-middle uk-flex-wrap">
    <div class="article-meta-single uk-flex uk-flex-middle">
        <img class="uk-preserve" src="<?php echo get_template_directory_uri(); ?>/resources/img/icon-author.svg" width="16" height="16" alt="Post Author" uk-svg>

        <span class="article-meta"><?php echo esc_html( $post['author'] ); ?></span>
    </div>

    <div class="article-meta-single uk-flex uk-flex-middle">
        <img class="uk-preserve" src="<?php echo get_template_directory_uri(); ?>/resources/img/icon-calendar.svg" width="16" height="16" alt="Post Date" uk-svg>

        <span class="article-meta"><?php echo esc_html( $post['date'] ); ?></span>
    </div>

    <div class="article-meta-single uk-flex uk-flex-middle">
        <img class="uk-preserve" src="<?php echo get_template_directory_uri(); ?>/resources/img/icon-clock.svg" width="16" height="16" alt="Reading Time" uk-svg>

        <span class="article-meta"><?php echo esc_html( $post['reading_time'] ); ?></span>
    </div>
</div>