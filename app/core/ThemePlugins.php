<?php
/**
 * ThemePlugins Class
 *
 * This file contains the ThemePlugins class which is responsible for managing
 * the required and recommended plugins for the Codehills Kickstarter theme. The
 * class includes methods for registering, activating, and deactivating plugins to
 * ensure that the theme functions correctly with the necessary plugins.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

 // Create theme functions class
class ThemePlugins {
    /**
     * Instance
     *
     * @since 2.0.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 2.0.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     * Class constructor
     *
     * Register theme functions action hooks and filters
     *
     * @since 2.0.0
     * @access public
     */
    public function __construct()
    {
        // Register required plugins
        add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
    }

    /**
     * Register required plugins
     * 
     * @since 2.0.0
     * @access public
     */
    public function register_required_plugins()
    {
        /*
         * Array of plugin arrays.
         * Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
        */
        $theme_plugins = array(    
            // Include a plugin bundled with a theme.
            array(
                'name'               => 'Advanced Custom Fields', // The plugin name.
                'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
                'source'             => get_template_directory() . '/includes/libs/tgm-plugin/plugins/advanced-custom-fields-pro.zip', // The plugin source.
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url'       => '', // If set, overrides default API URL and points to an external URL.
                'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
            ),
    
            // Include a plugin from the WordPress Plugin Repository.
            array(
                'name'      => 'Classic Editor',
                'slug'      => 'classic-editor',
                'required'  => false,
            ),
            array(
                'name'      => 'Contact Form 7',
                'slug'      => 'contact-form-7',
                'required'  => false,
            ),
            array(
                'name'      => 'Rank Math SEO',
                'slug'      => 'seo-by-rank-math',
                'required'  => false,
            ),
            array(
                'name'      => 'Safe SVG',
                'slug'      => 'safe-svg',
                'required'  => false,
            ),
            array(
                'name'      => 'Solid Security',
                'slug'      => 'better-wp-security',
                'required'  => false,
            ),
            array(
                'name'      => 'Ultimate Addons for Contact Form 7',
                'slug'      => 'ultimate-addons-for-contact-form-7',
                'required'  => false,
            ),
            array(
                'name'      => 'WP Migrate Lite',
                'slug'      => 'wp-migrate-db',
                'required'  => false,
            ),
        );
    
        /*
         * Array of configuration settings. Amend each line as needed.
         *
         * TGMPA will start providing localized text strings soon. If you already have translations of our standard
         * strings available, please help us make TGMPA even better by giving us access to these translations or by
         * sending in a pull-request with .po file(s) with the translations.
         *
         * Only uncomment the strings in the config array if you want to customize the strings.
         */
        $config = array(
            'id'           => ThemeFunctions::TEXT_DOMAIN, // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                                   // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins',              // Menu slug.
            'parent_slug'  => 'themes.php',                         // Parent menu slug.
            'capability'   => 'edit_theme_options',                 // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                                 // Show admin notices or not.
            'dismissable'  => true,                                 // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                                   // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                                // Automatically activate plugins after installation or not.
            'message'      => '',                                   // Message to output right before the plugins table.
        );
    
        // Call TGMPA with theme plugins and configuration
        tgmpa( $theme_plugins, $config );
    }
}