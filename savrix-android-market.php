<?php
/*
Plugin Name: Savrix Play Store
Plugin URI: http://androidphoneitalia.it
Description: This plugin shows a badge containing icon, app name, price, developer name and rating of an Android App.
Version: 3.1.2
Author: Saverio Petrangelo
Author URI: http://androidphoneitalia.it
*/

// Shortcode to show app badges from the Google Play Store

define( 'SAVRIXPLAYSTORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'SAVRIXPLAYSTORE_URL', plugin_dir_url( __FILE__ ) );

require_once(SAVRIXPLAYSTORE_PATH . 'inc/core.php');

global $savrix_options;
$savrix_options = savrixplaystore_load_options();

if ($savrix_options['appbrain'] == 0)
	wp_register_style('savrix-style.css', SAVRIXPLAYSTORE_URL . "savrix-style-only-play.css");
else
	wp_register_style('savrix-style.css', SAVRIXPLAYSTORE_URL . "savrix-style.css");
	
wp_enqueue_style('savrix-style.css');

add_shortcode( 'app', 'market_code' );
add_shortcode( 'qr', 'sav_qr_code' );
add_shortcode( 'appicon', 'sav_icon_code' );

if (is_admin()) {
	require_once(SAVRIXPLAYSTORE_PATH . 'inc/savrix-options.php');
	add_action('admin_init', 'savrixplaystore_init' );
	add_action('admin_menu', 'savrixplaystore_add_page');
}

// remove settings when deactivate/uninstall the plugin
function savrix_on_deactivate() {
       delete_option('savrixplaystore');
}
register_deactivation_hook(__FILE__, 'savrix_on_deactivate');
?>