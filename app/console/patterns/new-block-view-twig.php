<?php
/**
 * New block view pattern for Twig template
 *
 * This file is responsible for creating a new block view pattern in the Codehills Kickstarter theme.
 * It retrieves necessary information from the console input to generate the block view with Twig template.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

// Get the block html class name from the console input
$html_class_name = $args['html_class_name'];

// Get block name from the console input
$block_name = $args['block_name'];

echo '<div class="' . $html_class_name . '-block">
        <div class="uk-container">
            {% include \'builder/partials/block-titles.twig\' with { \'block_global_settings\': block_global_settings } %}

            {% if block_global_settings.have_cta %}
                <div class="uk-child-width-auto@s uk-flex-center uk-flex-left@m uk-margin-medium-top uk-grid-small" uk-grid>
                    {{ get_ctas( block_global_settings.have_cta ) }}
                </div>
            {% endif %}
        </div>
    </div>
</section> <!-- ' . $block_name . ' block end -->';