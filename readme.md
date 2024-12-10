# WP Cleanup

A modern WordPress plugin to clean up default content and reset your site to its default state.

## Features

- 🧹 Remove default WordPress content (Hello World post, sample page, first comment)
- 📝 Clean up all posts and pages
- 🔌 Remove unnecessary plugins
- 🔄 Reset WordPress to its default state
- 🎨 Modern, user-friendly interface
- 🛡️ Secure operations with nonce verification
- 👤 Preserves admin account during reset

## Installation

1. Upload the `wpcleanup` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Tools > WP Cleanup to access the cleanup options

## Usage

The plugin provides four main functions:

### 1. Clean Default Content
Removes the default WordPress content including:
- Hello World post
- Sample page
- First comment
- Hello Dolly plugin

### 2. Clean All Posts
Removes all:
- Posts
- Pages
- Comments
- Associated metadata

### 3. Clean All Plugins
- Removes all plugins except WP Cleanup
- Deactivates plugins before removal
- Preserves WP Cleanup functionality

### 4. Reset to Default State
- Complete WordPress reset
- Maintains admin access
- Removes all customizations
- Resets to fresh installation state

## ⚠️ Important Notes

- All cleanup actions are **permanent** and cannot be undone
- Always backup your database before using this plugin
- Admin account is preserved during reset operations
- Requires WordPress 5.0 or higher

## Screenshots

1. Modern admin interface with clear actions
2. Success messages after operations
3. Warning messages for destructive actions

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the GPL v2 or later - see the [LICENSE](LICENSE) file for details.
