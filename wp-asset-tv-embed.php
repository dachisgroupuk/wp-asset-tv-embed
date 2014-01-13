<?php
/**
 * Plugin Name: WP Asset TV Video Embed
 * Description: This allows for the embedding of Asset TV video content from their URLs
 * Version: 1.0
 * Author: Dachis Group
 * Author URI: http://dachisgroup.com
 *
 */
 if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) || !function_exists( 'add_action' ) ) {
	if ( !function_exists( 'add_action' ) ) {
		$exit_msg = 'I\'m just a plugin, please don\'t call me directly';
	} else {
		$exit_msg = sprintf( __( 'This version of WP Asset TV Embed required WordPress 3.1 or greater.' ) );
	}
	exit( $exit_msg );
}

// our version number. Don't touch this or any line below
// unless you know exactly what you are doing
define( 'WPATEPATH', trailingslashit( dirname( __FILE__ ) ) );
define( 'WPATEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );
define( 'WPATEURL', plugin_dir_url( dirname( __FILE__ ) ) . WPATEDIR );


// Set maximum execution time to 5 minutes - won't affect safe mode
$safe_mode = array( 'On', 'ON', 'on', 1 );
if ( !in_array( ini_get( 'safe_mode' ), $safe_mode ) && ini_get( 'max_execution_time' ) < 300 ) {
	@ini_set( 'max_execution_time', 300 );
}

global $wpAssetTVEmbed;

require_once( WPATEPATH . 'classes/wpate-core.php' );
require_once( WPATEPATH . 'classes/wpate-frontend.php' );
require_once( WPATEPATH . 'classes/wpate-admin.php' );

if ( is_admin() ){
    $wpAssetTVEmbed = new WpAssetTvEmbedAdmin();
} else {
    $wpAssetTVEmbed = new WpAssetTvEmbedFrontend();
}

$wpAssetTVEmbed->init();
