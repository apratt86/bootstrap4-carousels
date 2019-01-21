<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.apdevops.com
 * @since      1.0.0
 *
 * @package    Bootstrap4_Carousels
 * @subpackage Bootstrap4_Carousels/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bootstrap4_Carousels
 * @subpackage Bootstrap4_Carousels/includes
 * @author     Aaron Pratt <aaronprattdesign@gmail.com>
 */
class Bootstrap4_Carousels_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$requiredPlugins = array(
			'Meta Box' => 'meta-box/meta-box.php',
			'MB Settings Page' => 'mb-settings-page/mb-settings-page.php',
			'Meta Box Group' => 'meta-box-group/meta-box-group.php',
			'Meta Box Tabs' => 'meta-box-tabs/meta-box-tabs.php',
			'Meta Box Conditional Logic' => 'meta-box-conditional-logic/meta-box-conditional-logic.php',
		);

		foreach ( $requiredPlugins as $reqPluginName => $reqPluginSlug ){
			if ( !is_plugin_active( $reqPluginSlug ) ){
				wp_die( $reqPluginName . ' Plugin Must be installed and actived to use this plugin.<br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>' );
			}
		}
	}
}