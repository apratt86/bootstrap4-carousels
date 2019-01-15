<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.apdevops.com
 * @since             1.0.0
 * @package           Bootstrap4_Carousels
 *
 * @wordpress-plugin
 * Plugin Name:       Bootstrap 4 Carousels
 * Plugin URI:        https://github.com/apratt86/bootstrap4-carousels
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Aaron Pratt
 * Author URI:        https://www.apdevops.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

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

	$plugin = new Bootstrap4_Carousels();
	$plugin->run();

}
run_bootstrap4_carousels();