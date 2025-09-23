<?php
/**
 * ThemePlugins Class
 *
 * Manages required/recommended plugins for the Codehills Kickstarter theme.
 * - Installs wp.org plugins via core APIs
 * - Installs ACF PRO from bundled ZIP
 * - Adds Appearance → Theme Plugins admin screen with actions
 *
 * @since 2.2.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Core;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

// Create theme plugins class
class ThemePlugins {
    /**
     * Instance
     *
     * @since 2.2.0
     * @access private
     * @static
     *
     * @var ThemeFunctions The single instance of the class.
     */
    private static $instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 2.2.0
     * @access public
     *
     * @return ThemeFunctions An instance of the class.
     */
    public static function instance()
    {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
        endif;

        return self::$instance;
    }

    /**
     * Theme constants
     *
     * Register theme plugins class constants
     *
     * @since 2.2.0
     * @access public
     */
    const ACF_PRO_ZIP_REL = '/plugins/advanced-custom-fields-pro.zip';
    const MENU_SLUG       = 'codehills-kickstarter-theme-plugins';
    const CAPABILITY      = 'edit_theme_options';
    const NONCE_ACTION    = 'codehills_theme_plugins_action';

    /**
     * Plugins list
     * 
     * @since 2.2.0
     * @access private
     * @var array List of plugins to manage
     */
    private $plugins = [
        // Bundled ACF PRO (required)
        [
            'name'       => 'Advanced Custom Fields PRO',
            'slug'       => 'advanced-custom-fields-pro',
            'file'       => 'advanced-custom-fields-pro/acf.php',
            'required'   => true,
            'source'     => 'bundled',
            'zip_rel'    => self::ACF_PRO_ZIP_REL,
        ],

        // WordPress.org plugins
        [
            // Classic Editor
            'name'      => 'Classic Editor',
            'slug'      => 'classic-editor',
            'file'      => 'classic-editor/classic-editor.php',
            'required'  => false,
            'source'    => 'wporg'
        ],
        [
            // Contact Form 7
            'name'     => 'Contact Form 7',
            'slug'     => 'contact-form-7',
            'file'     => 'contact-form-7/wp-contact-form-7.php',
            'required' => false,
            'source'   => 'wporg',
        ],
        [
            // Rank Math SEO
            'name'     => 'Rank Math SEO',
            'slug'     => 'seo-by-rank-math',
            'file'     => 'seo-by-rank-math/rank-math.php',
            'required' => false,
            'source'   => 'wporg',
        ],
        [
            // Safe SVG
            'name'     => 'Safe SVG',
            'slug'     => 'safe-svg',
            'file'     => 'safe-svg/safe-svg.php',
            'required' => false,
            'source'   => 'wporg',
        ],
        [
            // Solid Security (iThemes Security)
            'name'     => 'Solid Security',
            'slug'     => 'better-wp-security',
            'file'     => 'better-wp-security/better-wp-security.php',
            'required' => false,
            'source'   => 'wporg',
        ],
        [
            // Ultimate Addons for Contact Form 7
            'name'     => 'Ultimate Addons for Contact Form 7',
            'slug'     => 'ultimate-addons-for-contact-form-7',
            'file'     => 'ultimate-addons-for-contact-form-7/ultimate-addons-for-contact-form-7.php',
            'required' => false,
            'source'   => 'wporg',
        ],
        [
            // WP Migrate Lite
            'name'     => 'WP Migrate Lite',
            'slug'     => 'wp-migrate-db',
            'file'     => 'wp-migrate-db/wp-migrate-db.php',
            'required' => false,
            'source'   => 'wporg',
        ],
        [
            // Duplicate Page
            'name'     => 'Duplicate Page',
            'slug'     => 'duplicate-page',
            'file'     => 'duplicate-page/duplicatepage.php',
            'required' => false,
            'source'   => 'wporg',
        ],
    ];

    /**
     *  Theme plugins class constructor
     *
     * Register theme plugins action hooks and filters
     *
     * @since 2.2.0
     * @access public
     */
    public function __construct()
    {
        // Admin UI + actions
        add_action('admin_menu', [ $this, 'add_menu' ]);
        add_action('admin_init', [ $this, 'handle_actions' ]);
        add_action('admin_notices', [ $this, 'maybe_notice_missing_required' ]);

        // Optional: after theme switch, prompt to install required
        add_action('after_switch_theme', function() {
            // no-op; the notice will handle prompting
        });
    }

    /**
     * Add admin menu
     * 
     * Add "Appearance → Theme Plugins" admin menu
     * 
     * @since 2.2.0
     * @access public
     * @return void
     */
    public function add_menu()
    {
        add_theme_page(
            __( 'Theme Plugins', 'codehills-kickstarter' ),
            __( 'Theme Plugins', 'codehills-kickstarter' ),
            self::CAPABILITY,
            self::MENU_SLUG,
            [ $this, 'render_page' ]
        );
    }

    /**
     * Render admin page
     * 
     * Render the "Appearance → Theme Plugins" admin page
     * 
     * @since 2.2.0
     * @access public
     * @return void
     */
    public function render_page()
    {
        // Permission check
        if( ! current_user_can( self::CAPABILITY ) ) :
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'codehills-kickstarter' ) );
        endif;

        // Get status of all plugins
        $status = $this->scan_status();

        // Create nonce for actions
        $nonce = wp_create_nonce( self::NONCE_ACTION );

        // Start rendering page output
        echo '<div class="wrap"><h1>' . esc_html__( 'Theme Plugins', 'codehills-kickstarter' ) . '</h1>';

        // Bulk button
        $missing_or_inactive = array_filter( $status, function( $plugin ) {
            return ! $plugin['installed'] || ! $plugin['active'];
        } );

        // CTA for bulk install/activate if any missing/inactive
        if ( ! empty($missing_or_inactive) ) :
            // Get bulk action URL
            $bulk_url = add_query_arg( [
                'page'      => self::MENU_SLUG,
                'action'    => 'bulk_install_activate',
                '_wpnonce'  => $nonce,
            ], admin_url( 'themes.php' ) );

            // Render button
            echo '<p><a href="' . esc_url( $bulk_url ) . '" class="button button-primary">' . esc_html__( 'Install & Activate All', 'codehills-kickstarter' ) . '</a></p>';
        endif;

        // Create table and table header for plugins
        echo '<table class="widefat striped">
            <thead>
                <tr>
                    <th>' . esc_html__( 'Plugin', 'codehills-kickstarter' ) . '</th>
                    <th>' . esc_html__( 'Source', 'codehills-kickstarter' ) . '</th>
                    <th>' . esc_html__( 'Required', 'codehills-kickstarter' ) . '</th>
                    <th>' . esc_html__( 'Status', 'codehills-kickstarter' ) . '</th>
                    <th>' . esc_html__( 'Actions', 'codehills-kickstarter' ) . '</th>
                </tr>
            </thead>
            
            <tbody>';

        // Build table rows for each plugin
        foreach( $status as $row ) :
            // Reset actions array
            $actions = [];

            // Set up action links based on status
            if( ! $row['installed'] ) :
                $actions[] = $this->action_link( 'install', $row['slug'], __( 'Install', 'codehills-kickstarter' ), $nonce );
            elseif( ! $row['active'] ) :
                $actions[] = $this->action_link( 'activate', $row['slug'], __( 'Activate', 'codehills-kickstarter' ), $nonce );
            else:
                $actions[] = '<span class="dashicons dashicons-yes" title="' . esc_attr__( 'Active', 'codehills-kickstarter' ) . '"></span>';
            endif;

            // Render table row
            echo '<tr>
                <td><strong>' . esc_html($row['name']) . '</strong><br><code>' . esc_html($row['file']) . '</code></td>
                <td>' . esc_html( $row['source'] === 'bundled' ? 'Bundled ZIP' : 'WordPress.org' ) . '</td>
                <td>' . ( $row['required'] ? '<span class="dashicons dashicons-lock"></span> ' . esc_html__( 'Required', 'codehills-kickstarter' ) : esc_html__( 'Recommended', 'codehills-kickstarter' ) ) . '</td>
                <td>' . esc_html( $row['installed'] ? ( $row['active'] ? __( 'Installed & Active', 'codehills-kickstarter' ) : __( 'Installed (inactive)', 'codehills-kickstarter' ) ) : __( 'Not installed', 'codehills-kickstarter' ) ) . '</td>
                <td>' . implode(' ', $actions) . '</td>
            </tr>';
        endforeach;

        // Close table and wrap
        echo '</tbody></table></div>';
    }

    /**
     * Generate action link
     *
     * Generate an action link for install/activate with nonce
     * 
     * @since 2.2.0
     * @access private
     * @param string $action
     * @param string $slug
     * @param string $label
     * @param string $nonce
     * @return string
     */
    private function action_link( $action, $slug, $label, $nonce )
    {
        // Build URL with nonce
        $url = add_query_arg([
            'page'      => self::MENU_SLUG,
            'action'    => $action,
            'slug'      => $slug,
            '_wpnonce'  => $nonce,
        ], admin_url( 'themes.php' ) );

        // Button class for install
        $class = $action === 'install' ? 'button button-primary' : 'button';

        // Return link HTML
        return '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
    }

    /**
     * Handle actions
     * 
     * Handle install/activate actions from admin page
     * 
     * @since 2.2.0
     * @access public
     * @return void
     */
    public function handle_actions()
    {
        // Verify context and permissions
        if ( ! is_admin() ) return;

        // Only handle our page
        if ( ! isset( $_GET['page'] ) || $_GET['page'] !== self::MENU_SLUG ) return;

        // Verify action
        if ( empty( $_GET['action'] ) ) return;

        // Verify user capabilities
        if ( ! current_user_can( self::CAPABILITY ) ) return;

        // Verify nonce
        check_admin_referer( self::NONCE_ACTION );

        // Get action key
        $action = sanitize_key( $_GET['action'] );

        // Handle bulk install/activate
        if ( $action === 'bulk_install_activate' ) :
            // Perform bulk install/activate
            $this->bulk_install_activate();

            return;
        endif;

        // Get plugin slug
        $slug = isset( $_GET['slug'] ) ? sanitize_key( $_GET['slug'] ) : '';

        // Validate slug
        if ( ! $slug ) return;

        // Get plugin by slug
        $plugin = $this->get_plugin_by_slug( $slug );

        // Validate plugin
        if ( ! $plugin ) return;

        // Handle individual install/activate
        if( $action === 'install' ) :
            // Perform install
            $ok = $this->install( $plugin );

            // Redirect with message
            $this->redirect_with_msg( $ok ? 'installed' : 'install_failed', $slug );
        elseif( $action === 'activate' ) :
            // Perform activate
            $ok = $this->activate( $plugin );

            // Redirect with message
            $this->redirect_with_msg( $ok ? 'activated' : 'activate_failed', $slug );
        endif;
    }

    /**
     * Bulk install and activate
     * 
     * Bulk install and activate all required/recommended plugins
     * 
     * @since 2.2.0
     * @access private
     * @return void
     */
    private function bulk_install_activate()
    {
        // Get status of all plugins
        $status = $this->scan_status();

        // Track overall success
        $ok_all = true;

        // Loop through each plugin and install/activate as needed
        foreach( $status as $plugin ) :
            // Install if not installed
            if ( ! $plugin['installed'] ) :
                $ok_all = $this->install( $plugin ) && $ok_all;
            endif;
            
            // Try activate regardless, if installed but inactive
            if ( $this->is_installed( $plugin['file'] ) && ! $this->is_active( $plugin['file'] ) ) :
                $ok_all = $this->activate( $plugin ) && $ok_all;
            endif;
        endforeach;

        // Redirect with message
        $this->redirect_with_msg($ok_all ? 'bulk_ok' : 'bulk_partial', '');
    }

    /**
     * Redirect with message
     * 
     * Redirect back to the admin page with a message code
     * 
     * @since 2.2.0
     * @access private
     * @param string $code
     * @param string $slug
     * @return void
     */
    private function redirect_with_msg( $code, $slug )
    {
        // Build redirect URL with message
        $url = add_query_arg([
            'page'  => self::MENU_SLUG,
            'msg'   => $code,
            'slug'  => $slug,
        ], admin_url( 'themes.php' ) );

        // Redirect
        wp_safe_redirect( $url );

        exit;
    }

    /**
     * Maybe notice missing required
     * 
     * Show admin notice if any required plugins are missing or inactive
     * 
     * @since 2.2.0
     * @access public
     * @return void
     */
    public function maybe_notice_missing_required()
    {
        // Only show to users with capability
        if ( ! current_user_can( self::CAPABILITY ) ) return;

        // Check for any required plugins missing or inactive
        $missing = array_filter( $this->scan_status(), function( $plugin ) {
            return $plugin['required'] && ( ! $plugin['installed'] || ! $plugin['active'] );
        } );

        // If none missing, no notice
        if ( empty( $missing ) ) return;

        // Show admin notice with link to Theme Plugins page
        $url = add_query_arg( [ 'page' => self::MENU_SLUG ], admin_url( 'themes.php' ) );

        // Render notice
        echo '<div class="notice notice-warning is-dismissible">
            <p>' . esc_html__( 'Codehills Kickstarter: Required plugins are missing or inactive.', 'codehills-kickstarter' ) . '
                <a class="button button-primary" href="'.esc_url( $url ).'">' . esc_html__( 'Review & Install', 'codehills-kickstarter' ) . '</a>
            </p>
        </div>';
    }

    /**
     * Scan status
     * 
     * Scan the status of all managed plugins
     * 
     * @since 2.2.0
     * @access private
     * @return array
     */
    private function scan_status()
    {
        // Initialize rows array
        $rows = [];

        // Loop through each plugin and check status
        foreach ( $this->plugins as $plugin ) :
            $rows[] = array_merge( $plugin, [
                'installed' => $this->is_installed( $plugin['file'] ),
                'active'    => $this->is_active( $plugin['file'] ),
            ]);
        endforeach;

        return $rows;
    }

    /**
     * Get plugin by slug
     * 
     * Get plugin array by slug
     * 
     * @since 2.2.0
     * @access private
     * @param string $slug
     * @return array|null
     */
    private function get_plugin_by_slug( $slug )
    {
        // Loop through plugins to find by slug
        foreach( $this->plugins as $plugin ) :
            if ( $plugin['slug'] === $slug ) return $plugin;
        endforeach;

        return null;
    }

    /**
     * Is installed
     * 
     * Check if a plugin is installed by file path
     * 
     * @since 2.2.0
     * @access private
     * @param string $file
     * @return bool
     */
    private function is_installed( $file )
    {
        // Check if plugin file exists in plugins directory
        return file_exists( WP_PLUGIN_DIR . '/' . $file );
    }

    /**
     * Is active
     * 
     * Check if a plugin is active by file path
     * 
     * @since 2.2.0
     * @access private
     * @param string $file
     * @return bool
     */
    private function is_active( $file )
    {
        // Include plugin functions if needed
        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        // Check if plugin is active
        return is_plugin_active( $file );
    }

    /**
     * Install plugin
     * 
     * Install a plugin (from wp.org or bundled ZIP)
     * 
     * @since 2.2.0
     * @access private
     * @param array $plugin
     * @return bool
     */
    private function install( $plugin )
    {
        // Determine source and install accordingly
        if( $plugin['source'] === 'wporg' ) :
            // WordPress.org plugin
            return $this->install_from_wporg( $plugin['slug'] );
        else :
            // Bundled ZIP
            $zip = get_template_directory() . $plugin['zip_rel'];

            // Install from ZIP
            return $this->install_from_zip( $zip );
        endif;
    }

    /**
     * Activate plugin
     * 
     * Activate a plugin by file path
     * 
     * @since 2.2.0
     * @access private
     * @param array $plugin
     * @return bool
     */
    private function activate( $plugin )
    {
        // Include plugin functions if needed
        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        // Activate plugin
        $result = activate_plugin( $plugin['file'] );

        // Return success status
        return ! is_wp_error( $result );
    }

    /**
     * Ensure filesystem access
     * 
     * Ensure we have filesystem access for installations
     * 
     * @since 2.2.0
     * @access private
     * @return bool
     */
    private function ensure_fs()
    {
        // Include file system functions if needed
        include_once ABSPATH . 'wp-admin/includes/file.php';

        // Check if filesystem is already accessible
        $credentials = request_filesystem_credentials( '', '', false, false, null );

        // Try to initialize filesystem
        if ( $credentials && WP_Filesystem( $credentials ) ) :
            return true;
        endif;

        return false;
    }

    /**
     * Install from WordPress.org
     * 
     * Install a plugin from WordPress.org by slug
     * 
     * @since 2.2.0
     * @access private
     * @param string $slug
     * @return bool
     */
    private function install_from_wporg( $slug )
    {
        // Ensure filesystem access
        if ( ! $this->ensure_fs() ) return false;

        // Include necessary files for plugin installation
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        // Get plugin info from WordPress.org API
        $api = plugins_api( 'plugin_information', [
            'slug'      => $slug,
            'fields'    => [ 'sections' => false ]
        ] );

        // Validate API response
        if ( is_wp_error( $api ) || empty( $api->download_link ) ) return false;

        // Install plugin using Plugin_Upgrader
        $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );

        // Perform installation
        $result = $upgrader->install( $api->download_link );

        // Return success status
        return ( $result && ! is_wp_error( $result ) );
    }

    /**
     * Install from ZIP
     * 
     * Install a plugin from a bundled ZIP file
     * 
     * @since 2.2.0
     * @access private
     * @param string $zip_path
     * @return bool
     */
    private function install_from_zip( $zip_path )
    {
        // Validate ZIP path
        if ( ! file_exists( $zip_path ) ) return false;

        // Ensure filesystem access
        if ( ! $this->ensure_fs() ) return false;

        // Include necessary files for plugin installation
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        // Install plugin using Plugin_Upgrader
        $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );

        // Perform installation
        $result = $upgrader->install( $zip_path );

        // Return success status
        return ( $result && ! is_wp_error( $result ) );
    }
}

// Initialize the ThemePlugins class
ThemePlugins::instance();