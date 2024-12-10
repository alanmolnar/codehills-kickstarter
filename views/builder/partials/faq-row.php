<?php
/**
 * FAQ Row Template Part
 *
 * This template part displays a single FAQ row. It includes the FAQ category, question,
 * and answer. This partial can be included in other templates to display individual FAQ items.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

if( ! defined( 'WPINC' ) ) :
    die;
endif;

// Get details
$category   = $args['faq']['category'];
$question   = $args['faq']['question'];
$answer     = $args['faq']['answer'];

echo '<li class="' . ( $category['value'] != null ? 'tag-' . $category['value'] : '' ) . '">
    <a class="uk-accordion-title" href="#">
        <div>' . $question . ' </div>
    </a>

    <div class="uk-accordion-content">' . $answer . '</div>
</li>';