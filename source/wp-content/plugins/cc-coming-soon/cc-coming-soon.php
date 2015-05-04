<?php
/**
 *
 * @package   CcComingSoon
 * @author    Chop-Chop.org <talk@chop-chop.org>
 * @license   GPL-2.0+
 * @link      https://shop.chop-chop.org
 * @copyright 2014
 *
 * @wordpress-plugin
 * Plugin Name:       Coming Soon CC
 * Plugin URI:        https://shop.chop-chop.org
 * Description:       An elegant Coming Soon page in just a few clicks.
 * Version:           2.0.1
 * Author:            Chop-Chop.org
 * Author URI:        http://chop-chop.org
 * Text Domain:       cc-coming-soon-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'vendor/autoload_52.php' );

define( 'CC_CS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CC_CS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-cc-coming-soon.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'CcComingSoon', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'CcComingSoon', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'CcComingSoon', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	if ( ! class_exists( 'AdminPageFramework' ) )
    	include_once( plugin_dir_path( __FILE__ ) . 'admin/includes/admin-page-framework/admin-page-framework.min.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-cc-coming-soon-admin.php' );
	add_action( 'init', array( 'CcComingSoonAdmin', 'get_instance' ) );

}

