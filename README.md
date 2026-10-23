# WordPress Plugin Dependency Detection

A practical PHP example for checking whether a required WordPress plugin is active and displaying an admin notice when a dependency is missing.

## Overview

WordPress plugins sometimes depend on other plugins to provide specific classes, functions, or features. If a required plugin is inactive or unavailable, dependent functionality may fail.

This repository demonstrates how to check for WooCommerce availability and notify administrators when the dependency is missing.

## PHP Snippet

The implementation is available in [`check-plugin-dependency.php`](check-plugin-dependency.php).

```php
<?php
/**
 * Check whether WooCommerce is available.
 */

add_action( 'plugins_loaded', 'kw_check_plugin_dependency' );

function kw_check_plugin_dependency() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', 'kw_missing_woocommerce_notice' );
    }
}

function kw_missing_woocommerce_notice() {
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }

    echo '<div class="notice notice-warning"><p>';
    echo esc_html(
        'This feature requires WooCommerce to be installed and active.'
    );
    echo '</p></div>';
}
```

## How It Works

- `plugins_loaded` runs after WordPress has loaded active plugins.
- `class_exists( 'WooCommerce' )` checks whether the WooCommerce class is available.
- `admin_notices` registers a notice in the WordPress dashboard.
- `current_user_can( 'activate_plugins' )` limits the notice to users with the required capability.
- `esc_html()` safely escapes the notice text before displaying it.

## Installation

1. Back up your website before making changes.
2. Open your child theme's `functions.php` file or a trusted PHP snippets plugin.
3. Copy the contents of `check-plugin-dependency.php`.
4. Add the code in the appropriate location, avoiding a duplicate PHP opening tag.
5. Save the changes and open the WordPress administration dashboard.
6. Test the behavior with WooCommerce active and inactive in a staging environment.

**Important:** The PHP file is a reusable snippet, not a standalone plugin. Do not upload it to the WordPress plugins directory expecting it to run automatically.

## Expected Behavior

**When WooCommerce is active:** The WooCommerce class should be available, and the warning notice should not appear.

**When WooCommerce is inactive or unavailable:** The dashboard should display a warning to users who have the `activate_plugins` capability.

## Customization

To check a different dependency, replace `WooCommerce` with the relevant class name provided by the required plugin and update the notice message.

For example:

```php
if ( ! class_exists( 'Required_Plugin_Class' ) ) {
    // Handle the missing dependency.
}
```

Use the actual class name documented by the plugin. Class names are examples and are not interchangeable between plugins.

## Troubleshooting

### The warning appears even though WooCommerce is active

- Confirm WooCommerce is activated on the correct site.
- Verify the actual class name used by the installed version.
- Check for PHP errors that prevent WooCommerce from loading.
- Review plugin load order and compatibility.

### The notice does not appear

- Confirm that the snippet is running.
- Check whether the current user has the `activate_plugins` capability.
- Review PHP error logs.
- Verify that the missing dependency is detected by the class check.

### A dependent plugin still produces a fatal error

This notice is diagnostic only. It does not automatically stop other plugins from executing or prevent all dependency-related fatal errors. Dependent code must also be designed to handle missing dependencies safely.

## Best Practices

- Check dependencies before using their classes or functions.
- Follow the dependency plugin's documented API.
- Avoid assuming that a plugin's display name is its PHP class name.
- Test activation, deactivation, and upgrade scenarios.
- Keep production error reporting configured safely.
- Prefer explicit plugin dependency declarations when developing a standalone WordPress plugin.

## Repository Structure

```text
wordpress-detect-missing-plugin-dependencies/
├── README.md
└── check-plugin-dependency.php
```

## Disclaimer

This snippet is provided for educational and troubleshooting purposes. Test it in a staging environment before deploying it to a production website.

## References

- [WordPress Plugin API](https://developer.wordpress.org/plugins/)
- [WordPress `plugins_loaded` hook](https://developer.wordpress.org/reference/hooks/plugins_loaded/)
- [WordPress `admin_notices` hook](https://developer.wordpress.org/reference/hooks/admin_notices/)
- [PHP `class_exists()` documentation](https://www.php.net/manual/en/function.class-exists.php)
