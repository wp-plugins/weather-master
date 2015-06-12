<?php
/**
Plugin Name: Weather Master
Plugin URI: http://wordpress.techgasp.com/weather-master/
Version: 4.4.2.0
Author: TechGasp
Author URI: http://wordpress.techgasp.com
Text Domain: weather-master
Description: Weather Master is the heavy duty, professional wordpress weather plugin. Just like on TV.
License: GPL2 or later
*/
/*
Copyright 2013 TechGasp  (email : info@techgasp.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(!class_exists('weather_master')) :
///////DEFINE DIR///////
define( 'WEATHER_MASTER_DIR', plugin_dir_path( __FILE__ ) );
///////DEFINE URL///////
define( 'WEATHER_MASTER_URL', plugin_dir_url( __FILE__ ) );
///////DEFINE ID//////
define( 'WEATHER_MASTER_ID', 'weather-master');
///////DEFINE VERSION///////
define( 'WEATHER_MASTER_VERSION', '4.4.2.0' );
global $weather_master_version, $weather_master_name;
$weather_master_version = "4.4.2.0"; //for other pages
$weather_master_name = "Weather Master"; //pretty name
if( is_multisite() ) {
update_site_option( 'weather_master_installed_version', $weather_master_version );
update_site_option( 'weather_master_name', $weather_master_name );
}
else{
update_option( 'weather_master_installed_version', $weather_master_version );
update_option( 'weather_master_name', $weather_master_name );
}
// HOOK ADMIN
require_once( dirname( __FILE__ ) . '/includes/weather-master-admin.php');
// HOOK ADMIN IN & UN SHORTCODE
require_once( dirname( __FILE__ ) . '/includes/weather-master-admin-shortcodes.php');
// HOOK ADMIN WIDGETS
require_once( dirname( __FILE__ ) . '/includes/weather-master-admin-widgets.php');
// HOOK ADMIN ADDONS
require_once( dirname( __FILE__ ) . '/includes/weather-master-admin-addons.php');
// HOOK ADMIN UPDATER
require_once( dirname( __FILE__ ) . '/includes/weather-master-admin-updater.php');
// HOOK WIDGET WEATHER BASIC
require_once( dirname( __FILE__ ) . '/includes/weather-master-widget-basic.php');

class weather_master{
//REGISTER PLUGIN
public static function weather_master_register(){
register_activation_hook( __FILE__, array( __CLASS__, 'weather_master_activate' ) );
}
public static function content_with_quote($content){
$quote = '<p>' . get_option('tsm_quote') . '</p>';
	return $content . $quote;
}
//SETTINGS LINK IN PLUGIN MANAGER
public static function weather_master_links( $links, $file ) {
if ( $file == plugin_basename( dirname(__FILE__).'/weather-master.php' ) ) {
		if( is_network_admin() ){
		$techgasp_plugin_url = network_admin_url( 'admin.php?page=weather-master' );
		}
		else {
		$techgasp_plugin_url = admin_url( 'admin.php?page=weather-master' );
		}
	$links[] = '<a href="' . $techgasp_plugin_url . '">'.__( 'Settings' ).'</a>';
	}
	return $links;
}

public static function weather_master_updater_version_check(){
global $weather_master_version;
//CHECK NEW VERSION
$weather_master_slug = basename(dirname(__FILE__));
$current = get_site_transient( 'update_plugins' );
$weather_plugin_slug = $weather_master_slug.'/'.$weather_master_slug.'.php';
@$r = $current->response[ $weather_plugin_slug ];
if (empty($r)){
$r = false;
$weather_plugin_slug = false;
if( is_multisite() ) {
update_site_option( 'weather_master_newest_version', $weather_master_version );
}
else{
update_option( 'weather_master_newest_version', $weather_master_version );
}
}
if (!empty($r)){
$weather_plugin_slug = $weather_master_slug.'/'.$weather_master_slug.'.php';
@$r = $current->response[ $weather_plugin_slug ];
if( is_multisite() ) {
update_site_option( 'weather_master_newest_version', $r->new_version );
}
else{
update_option( 'weather_master_newest_version', $r->new_version );
}
}
}
//Remove WP Updater
// Advanced Updater
//Updater Label Message
//END CLASS
}
if ( is_admin() ){
	add_action('admin_init', array('weather_master', 'weather_master_register'));
	add_action('init', array('weather_master', 'weather_master_updater_version_check'));
}
add_filter('the_content', array('weather_master', 'content_with_quote'));
add_filter( 'plugin_action_links', array('weather_master', 'weather_master_links'), 10, 2 );
endif;