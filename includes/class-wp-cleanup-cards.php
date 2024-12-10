<?php
class WP_Cleanup_Cards {
    public static function render_card($title, $description, $action, $button_text, $danger = false) {
        $nonce = wp_create_nonce('wpcleanup_' . $action);
        ?>
        <div class="wpcleanup-card">
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($description); ?></p>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="wpcleanup_nonce" value="<?php echo esc_attr($nonce); ?>">
                <input type="hidden" name="action" value="wpcleanup_<?php echo esc_attr($action); ?>">
                <button type="submit" class="wpcleanup-button<?php echo $danger ? ' wpcleanup-button-danger' : ''; ?>">
                    <?php echo esc_html($button_text); ?>
                </button>
            </form>
        </div>
        <?php
    }

    public static function render_all_cards() {
        ?>
        <div class="wpcleanup-grid">
            <?php
            self::render_card(
                'Clean Default Content',
                'Remove default WordPress content (Hello World post, sample page, first comment, Hello Dolly plugin)',
                'clean_default',
                'Clean Default Content'
            );

            self::render_card(
                'Clean All Posts',
                'Remove all posts, pages, and comments from the site',
                'clean_posts',
                'Clean All Posts'
            );

            self::render_card(
                'Clean All Plugins',
                'Remove all plugins except WP Cleanup',
                'clean_plugins',
                'Clean All Plugins'
            );

            self::render_card(
                'Reset to Default State',
                'This will remove all content, plugins, and customizations, restoring WordPress to its default state',
                'reset_all',
                'Reset WordPress',
                true
            );
            ?>
        </div>
        <?php
    }
}