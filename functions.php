<?php

// Deletion: Sample content
function wp_cleanup_delete_sample_content() {
    $sample_post = get_page_by_title('Sample Post');
    if ($sample_post) { 
        if (!wp_delete_post($sample_post->ID, true)) {
            return false; // Deletion failed
        }
    }

    $sample_page = get_page_by_title('Sample Page');
    if ($sample_page) { 
        if (!wp_delete_post($sample_page->ID, true)) {
            return false; // Deletion failed
        }
    }

    return true; // Success
}

// Deletion: Plugins
function wp_cleanup_deactivate_and_delete_plugin($plugin) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php'); 

    if (is_plugin_active($plugin)) {
        deactivate_plugins($plugin);
    }

    if (delete_plugins(array($plugin))) {
        return true; // Success
    } else {
        return false; // Deletion failed
    }
}

// Success Notice
function wp_cleanup_success_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p>WP Cleanup actions completed successfully!</p>
    </div>
    <?php
}

// Error Notice
function wp_cleanup_error_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p>WP Cleanup encountered errors. Please check for potential conflicts and try again.</p>
    </div>
    <?php
}
