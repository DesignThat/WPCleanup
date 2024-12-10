<?php
class WP_Cleanup_Messages {
    private static $messages = [
        'default-cleaned' => 'Default content has been successfully removed.',
        'posts-cleaned' => 'All posts and pages have been successfully removed.',
        'plugins-cleaned' => 'All plugins have been successfully removed.',
        'wordpress-reset' => 'WordPress has been successfully reset to its default state.'
    ];

    public static function get_message($key) {
        return isset(self::$messages[$key]) ? self::$messages[$key] : '';
    }

    public static function render_success_message($message_key) {
        if (empty($message_key)) {
            return;
        }

        $message = self::get_message($message_key);
        if ($message) {
            echo '<div class="wpcleanup-success">' . esc_html($message) . '</div>';
        }
    }

    public static function render_warning() {
        ?>
        <div class="wpcleanup-warning">
            <p><strong>Warning:</strong> These actions cannot be undone. Please backup your database before proceeding.</p>
        </div>
        <?php
    }
}