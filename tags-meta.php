<?php
/**
 * Plugin Name: Tags Meta
 * Plugin URI: http://saberhr.com
 * Author: SaberHR
 * Author URI: http://saberhr.com
 * Description: WordPress Taxonomy Metabox API Demo
 * Licence: GPLv2 or Later
 * Text Domain: tags-meta
 */

function tags_meta_load_textdomain () {
	load_plugin_textdomain( 'tags_meta', false, plugin_dir_url( __FILE__ ) . '/languages' );
}
add_action('plugins_loaded', 'tags_meta_load_textdomain');