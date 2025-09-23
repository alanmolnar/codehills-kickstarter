<?php
/**
 * Article Content Template Part
 *
 * This template part displays the content of an article. It includes the article title
 * and the article content. This partial can be included in other templates to display
 * the content of an article.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Get post object
$post = isset( $args['post'] ) && ! empty( $args['post'] ) ? $args['post'] : null;

// Get previous post
$previous_post = isset( $args['previous_post'] ) && ! empty( $args['previous_post'] ) ? $args['previous_post'] : null;

// Get next post
$next_post = isset( $args['next_post'] ) && ! empty( $args['next_post'] ) ? $args['next_post'] : null;

// Get sidebar
$sidebar = isset( $args['sidebar'] ) ? (bool) $args['sidebar'] : false;

// Get sidebar content
$sidebar_content = isset( $args['sidebar_content'] ) ? $args['sidebar_content'] : ''; ?>

<!-- Article
============================================= -->
<article id="main" <?php post_class(); ?>>
    <div class="uk-container">
        <div uk-grid>
            <div class="article-content uk-width-2-3@m">
                <?php
                    // Article meta
                    get_template_part( 'views/template-parts/php/article-meta' );
                ?>

                <h1 class="uk-margin-small-top"><?php echo esc_html( $post['post_title'] ); ?></h1>

                <?php if ( ! empty( $post['image'] ) ) : ?>
                    <img class="img-border-radius uk-margin" src="<?php echo esc_url( $post['image'] ); ?>" width="844" height="400" alt="<?php echo esc_attr( $post['title'] ); ?>">
                <?php endif; ?>

                <?php echo $post['post_content']; ?>

                <hr class="uk-margin">

                <div class="uk-flex-between uk-flex-middle" uk-grid>
                    <?php
                        // Post categories
                        if ( ! empty( $post['terms'] ) ) :
                            echo '<div class="post-terms-list uk-flex uk-width-auto@s uk-margin-remove-bottom">';
                            foreach ( $post['terms'] as $term ) :
                                echo '<a class="uk-label uk-label-primary uk-disabled" href="' . esc_url( $term['permalink'] ) . '">' . esc_html( $term['name'] ) . '</a>';
                            endforeach;
                            echo '</div>';
                        endif;
                    ?>

                    <div class="uk-width-auto@s">
                        <?php get_template_part( 'views/template-parts/php/article-share-buttons' ); ?>
                    </div>
                </div>

                <hr class="uk-margin">

                <?php
                    // Posts navigation
                    if ( ! empty( $previous_post ) || ! empty( $next_post ) ) :
                        echo '<div class="posts-navigation uk-child-width-1-2@s uk-grid-small uk-margin-medium-top" uk-grid>';

                        // Previous post
                        if ( ! empty( $previous_post ) ) : ?>
                            <div>
                                <div class="posts-navigation-item">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-auto">
                                            <a href="<?php echo esc_url( $previous_post['permalink'] ); ?>" rel="prev">
                                                <img class="img-border-radius" src="<?php echo esc_url( $previous_post['image'] ); ?>" width="73" height="100" alt="<?php echo esc_attr( $previous_post['title'] ); ?>" style="width: 73px; height: 100px; object-fit: cover;">
                                            </a>
                                        </div>

                                        <div class="uk-width-expand">
                                            <span>Previous Blog</span>

                                            <a class="posts-navigation-title" href="<?php echo esc_url( $previous_post['permalink'] ); ?>" rel="prev"><?php echo esc_html( $previous_post['title'] ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                        
                        // Next post
                        if ( ! empty( $next_post ) ) : ?>
                            <div>
                                <div class="posts-navigation-item">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-auto">
                                            <a href="<?php echo esc_url( $next_post['permalink'] ); ?>" rel="prev">
                                                <img class="img-border-radius" src="<?php echo esc_url( $next_post['image'] ); ?>" width="73" height="100" alt="<?php echo esc_attr( $next_post['title'] ); ?>" style="width: 73px; height: 100px; object-fit: cover;">
                                            </a>
                                        </div>

                                        <div class="uk-width-expand">
                                            <span>Next Blog</span>

                                            <a class="posts-navigation-title" href="<?php echo esc_url( $next_post['permalink'] ); ?>" rel="prev"><?php echo esc_html( $next_post['title'] ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                        
                        echo '</div>';
                    endif;
                ?>
            </div>

            <?php
                // Sidebar
                if( $sidebar && $sidebar_content != '' ) :
                    echo '<div class="sidebar uk-width-1-3@s" uk-margin>';

                    // Render sidebar content
                    get_template_part( 'views/template-parts/php/sidebar', null, array( 'sidebar_content' => $sidebar_content ) );

                    echo '</div>';
                endif;
            ?>
        </div>
    </div>
</article> <!-- Article end -->