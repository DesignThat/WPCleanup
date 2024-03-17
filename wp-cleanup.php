<?php
/**
 * Plugin Name: WP Cleanup by DesignThat Cloud
 * Description: A customizable plugin to delete sample content and remove selected plugins.
 * Version: 1.0
 * Author: DesignThat Cloud
 * Author URI: https://designthat.cloud
 * Plugin URI: https://designthat.cloud/wordpress/wp-cleanup
 * License: GPLv2 or later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Constants
define('WP_CLEANUP_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Include functions file (optional, but recommended)
if (file_exists(dirname(__FILE__) . '/functions.php')) {
    require_once(dirname(__FILE__) . '/functions.php');
}

// Filter for default plugins
function wp_cleanup_by_designthat_cloud_default_plugins() {
    return apply_filters('wp_cleanup_default_plugins', array(
        'hello.php',
        'akismet/akismet.php'
    ));
}

// --- Admin Actions --- //
add_action('admin_init', 'wp_cleanup_by_designthat_cloud_actions');
function wp_cleanup_by_designthat_cloud_actions() {
    // Handle potential deletion actions if triggered
    if (isset($_GET['wp_cleanup_actions']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'wp_cleanup_actions')) {

        $delete_plugins = get_option('wp_cleanup_plugins', array());
        $results = array('success' => true, 'errors' => array());

        if (!wp_cleanup_delete_sample_content()) {
            $results['success'] = false;
            $results['errors'][] = "Failed to delete sample content.";
        }

        foreach ($delete_plugins as $plugin) {
            if (!wp_cleanup_deactivate_and_delete_plugin($plugin)) {
                $results['success'] = false;
                $results['errors'][] = "Error deleting plugin: " . $plugin; 
            }
        }

        // Display appropriate notices 
        if ($results['success']) {
            add_action('admin_notices', 'wp_cleanup_success_notice');
        } else {
            add_action('admin_notices', 'wp_cleanup_error_notice');
        }
    }
}

// --- Admin Settings Page --- //
add_action('admin_menu', 'wp_cleanup_by_designthat_cloud_settings_page');
function wp_cleanup_by_designthat_cloud_settings_page() {
    add_options_page('WP Cleanup', 'WP Cleanup', 'manage_options', 'wp-cleanup', 'wp_cleanup_by_designthat_cloud_settings_page_display');
}

// Settings Registration
add_action('admin_init', 'wp_cleanup_register_settings');
function wp_cleanup_register_settings() {
   register_setting('wp_cleanup_settings_group', 'wp_cleanup_plugins'); 
}

// Settings page display
function wp_cleanup_by_designthat_cloud_settings_page_display() { 
    // ... (Settings page form) ...
}

// --- Admin Notice Functions --- // 
function wp_cleanup_success_notice() {
    // ... (Implementation from `functions.php`)
}

function wp_cleanup_error_notice() {
    // ... (Implementation from `functions.php`)
}


