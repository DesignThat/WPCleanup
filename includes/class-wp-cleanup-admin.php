<?php
require_once plugin_dir_path(__FILE__) . 'class-wp-cleanup-messages.php';
require_once plugin_dir_path(__FILE__) . 'class-wp-cleanup-cards.php';

class WP_Cleanup_Admin {
    public function init() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        $this->register_handlers();
    }

    private function register_handlers() {
        $handlers = array('clean_default', 'clean_posts', 'clean_plugins', 'reset_all');
        foreach ($handlers as $handler) {
            add_action('admin_post_wpcleanup_' . $handler, array($this, 'handle_' . $handler));
        }
    }

    public function enqueue_admin_assets($hook) {
        if ('tools_page_wpcleanup' !== $hook) {
            return;
        }
        wp_enqueue_style('wpcleanup-admin', plugin_dir_url(dirname(__FILE__)) . 'assets/css/wpcleanup-admin.css', array(), '1.0.0');
    }

    public function add_admin_menu() {
        add_management_page(
            'WP Cleanup',
            'WP Cleanup',
            'manage_options',
            'wpcleanup',
            array($this, 'render_admin_page')
        );
    }

    public function render_admin_page() {
        ?>
        <div class="wpcleanup-container">
            <div class="wpcleanup-header">
                <h1>WordPress Cleanup</h1>
            </div>
            
            <?php 
            WP_Cleanup_Messages::render_success_message(isset($_GET['message']) ? $_GET['message'] : '');
            WP_Cleanup_Messages::render_warning();
            WP_Cleanup_Cards::render_all_cards();
            ?>
        </div>
        <?php
    }

    private function verify_request($action) {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        check_admin_referer('wpcleanup_' . $action, 'wpcleanup_nonce');
    }

    private function handle_action($action, $method) {
        $this->verify_request($action);
        call_user_func(array('WP_Cleanup', $method));
        wp_redirect(add_query_arg(
            array('page' => 'wpcleanup', 'message' => $action . '-cleaned'),
            admin_url('tools.php')
        ));
        exit;
    }

    public function handle_clean_default() {
        $this->handle_action('default', 'clean_default_content');
    }

    public function handle_clean_posts() {
        $this->handle_action('posts', 'clean_all_posts');
    }

    public function handle_clean_plugins() {
        $this->handle_action('plugins', 'clean_all_plugins');
    }

    public function handle_reset_all() {
        $this->handle_action('wordpress', 'reset_to_default');
    }
}