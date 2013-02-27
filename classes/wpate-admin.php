<?php
/**
 * Admin class to control the administration system options and pages
 *
 * Description: This allows for the embedding of Asset TV videos from their URLs
 * Version: 1.0
 * Author: Ross Tweedie
 * Author URI: http://www.dachisgroup.com
 */
class WpAssetTvEmbedAdmin extends WpAssetTvEmbedCore
{
    function init()
    {
        parent::init();

        add_action( 'admin_menu', array( __CLASS__, 'add_admin_pages' ) );

        register_deactivation_hook( $this->plugin_file, array( $this, 'uninstall' ) );
    }

    /**
     * Add the administration menu for the plugin
     *
     * @param void
     * @return void
     */
    function add_admin_pages()
    {
        add_media_page( __( 'Asset TV Embed' , 'imv'), __( 'Asset TV Embed' , 'imv'), 'create_users', 'asset-tv-embed', array( __CLASS__, 'index_page' ) );
    }


    function index_page()
    {
        $message = null;

        include( WpAssetTvEmbedAdmin::get_plugin_path() . 'views/admin-index.php' );
    }


    /**
     * Uninstall option
     *
     * This will be called when the plugin is disactivated or uninstalled.
     *
     * It will remove the wpkve settings from the options database table
     */
    function uninstall()
    {
        //When the plugin is uninstalled or deactivation, cleanup the options
        delete_option( WpAssetTvEmbedAdmin::$option_name );
    }

}
