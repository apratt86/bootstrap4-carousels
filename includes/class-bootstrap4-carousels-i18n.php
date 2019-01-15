<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.apdevops.com
 * @since      1.0.0
 *
 * @package    Bootstrap4_Carousels
 * @subpackage Bootstrap4_Carousels/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Bootstrap4_Carousels
 * @subpackage Bootstrap4_Carousels/includes
 * @author     Aaron Pratt <aaronprattdesign@gmail.com>
 */
class Bootstrap4_Carousels_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bootstrap4-carousels',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
