<?php
/*
Plugin Name: WP Fresh by DesignThat Cloud
Description: Deletes sample post and page, removes Hello Dolly and Akismet plugins, and recommends installing the Cloudflare plugin.
Version: 1.0
Author: DesignThat Cloud
Author URI: https://designthat.cloud/plugins/wp-fresh
*/

// Hook into the 'init' action
add_action('init', 'wp_fresh_by_designthat_cloud');

function wp_fresh_by_designthat_cloud() {
    // Delete sample post and page
    wp_delete_post(1, true); // Delete the sample post
    wp_delete_post(2, true); // Delete the sample page

    // Delete Hello Dolly plugin
    if (is_plugin_active('hello.php')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        deactivate_plugins('hello.php');
        delete_plugins(array('hello.php'));
    }

    // Delete Akismet plugin
    if (is_plugin_active('akismet/akismet.php')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        deactivate_plugins('akismet/akismet.php');
        delete_plugins(array('akismet/akismet.php'));
    }

    // Check if Cloudflare plugin is installed
    $cloudflare_plugin_path = WP_PLUGIN_DIR . '/cloudflare/cloudflare.php';
    if (!file_exists($cloudflare_plugin_path)) {
        add_action('admin_notices', 'wp_fresh_recommend_cloudflare');
    }
}

function wp_fresh_recommend_cloudflare() {
    ?>
    <div class="notice notice-info">
        <p><?php printf('We recommend installing the <a href="%s" target="_blank">Cloudflare plugin</a> to enhance your website performance and security.', 'https://wordpress.org/plugins/cloudflare/'); ?></p>
    </div>
    <?php
}
