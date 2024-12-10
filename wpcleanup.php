<?php
/*
Plugin Name: WP Cleanup
Plugin URI: https:/github.com/DesignThat/WPCleanup
Description: Clean up default WordPress content and optionally reset your site to its default state
Version: 1.0.0
Author: DesignThat Cloud
Author URI: https://designthat.cloud
License: GPL v2 or later
*/

if (!defined('ABSPATH')) {
    exit;
}

// Load required files
require_once plugin_dir_path(__FILE__) . 'includes/class-wp-cleanup.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-wp-cleanup-admin.php';

// Initialize the plugin
function wpcleanup_init() {
    $plugin = new WP_Cleanup();
    $plugin->init();
}
add_action('plugins_loaded', 'wpcleanup_init');