<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Posts2newsletter
 * @author    Tommy Fisher <tommybfisher@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014
 *
 * @wordpress-plugin
 * Plugin Name:       Posts2Newsletter
 * Plugin URI:        @TODO
 * Description:       @TODO
 * Version:           0.0.1
 * Author:            Tommy Fisher
 * Author URI:        http://tommyfisher.net
 * Text Domain:       posts2newsletter-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-posts2newsletter.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Posts2newsletter', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Posts2newsletter', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'Posts2newsletter', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-posts2newsletter-admin.php` with the name of the plugin's admin file
 * - replace Posts2newsletterAdmin with the name of the class defined in
 *   `class-posts2newsletter-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() /*&& ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX )*/ ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-posts2newsletter-admin.php' );
	add_action( 'plugins_loaded', array( 'Posts2newsletterAdmin', 'get_instance' ) );

    add_action( 'wp_ajax_save_campaign', 'save_campaign_callback' );

    // Load in the ajax functions
    require_once(plugin_dir_path( __FILE__ ) . 'admin/includes/ajax.php');
}
