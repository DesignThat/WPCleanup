<?php
class WP_Cleanup {
    private $admin;

    public function init() {
        if (is_admin()) {
            $this->admin = new WP_Cleanup_Admin();
            $this->admin->init();
        }
    }

    public static function clean_default_content() {
        // Delete default post
        wp_delete_post(1, true);
        
        // Delete default page
        wp_delete_post(2, true);
        
        // Delete default comment
        wp_delete_comment(1, true);
        
        // Delete Hello Dolly plugin if exists
        if (file_exists(WP_PLUGIN_DIR . '/hello.php')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
            deactivate_plugins('/hello.php');
            delete_plugins(array('hello.php'));
        }
        
        return true;
    }

    public static function clean_all_posts() {
        global $wpdb;
        
        // Delete all posts
        $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type IN ('post', 'page')");
        
        // Delete all comments
        $wpdb->query("DELETE FROM {$wpdb->comments}");
        
        // Reset post and comment counts
        $wpdb->query("DELETE FROM {$wpdb->postmeta}");
        $wpdb->query("DELETE FROM {$wpdb->commentmeta}");
        
        return true;
    }

    public static function clean_all_plugins() {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        
        // Get all plugins except our own
        $all_plugins = get_plugins();
        $plugins_to_delete = array();
        
        foreach ($all_plugins as $plugin_path => $plugin_data) {
            if (strpos($plugin_path, 'wpcleanup') === false) {
                deactivate_plugins($plugin_path);
                $plugins_to_delete[] = $plugin_path;
            }
        }
        
        if (!empty($plugins_to_delete)) {
            delete_plugins($plugins_to_delete);
        }
        
        return true;
    }

    public static function reset_to_default() {
        self::clean_all_posts();
        self::clean_all_plugins();
        
        // Reset widgets
        update_option('sidebars_widgets', array('wp_inactive_widgets' => array()));
        
        // Reset theme mods
        remove_theme_mods();
        
        // Reset user roles except admin
        global $wpdb;
        $admin_email = get_option('admin_email');
        $wpdb->query("DELETE FROM {$wpdb->users} WHERE user_email != '$admin_email'");
        $wpdb->query("DELETE FROM {$wpdb->usermeta} WHERE user_id NOT IN (SELECT ID FROM {$wpdb->users})");
        
        return true;
    }
}