<?php

/**
 * @link              https://www.apdevops.com
 * @since             1.0.0
 * @package           Bootstrap4_Carousels
 *
 * @wordpress-plugin
 * Plugin Name:       Bootstrap 4 Carousels
 * Plugin URI:        https://github.com/apratt86/bootstrap4-carousels
 * Description:       This plugin requires Bootstrap 4 to be loaded in your theme and Metabox plugin and Extensions.
 * Version:           1.0.0
 * Author:            Aaron Pratt
 * Author URI:        https://www.apdevops.com
 * Text Domain:       bootstrap4-carousels
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'bootstrap4_carousels_version', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bootstrap4-carousels-activator.php
 */
function activate_bootstrap4_carousels() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bootstrap4-carousels-activator.php';
	Bootstrap4_Carousels_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bootstrap4-carousels-deactivator.php
 */
function deactivate_bootstrap4_carousels() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bootstrap4-carousels-deactivator.php';
	Bootstrap4_Carousels_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bootstrap4_carousels' );
register_deactivation_hook( __FILE__, 'deactivate_bootstrap4_carousels' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bootstrap4-carousels.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bootstrap4_carousels() {

	$adminReqPartials = array(
		'bs4-carousel-admin-menu.php',
		'bs4-carousel-cpts.php',
		'bs4-carousel-options-page.php',
	);
	foreach ( $adminReqPartials as $adminReqFile ){
		require_once plugin_dir_path(__FILE__) . "admin/partials/{$adminReqFile}";
	}

	$publicReqPartials = array(
		'bs4-carousel-shortcode.php'
	);

	foreach ( $publicReqPartials as $publicReqFile ){
		require_once plugin_dir_path(__FILE__) . "public/partials/{$publicReqFile}";
	}

	$plugin = new Bootstrap4_Carousels();
	$plugin->run();

}
run_bootstrap4_carousels();
