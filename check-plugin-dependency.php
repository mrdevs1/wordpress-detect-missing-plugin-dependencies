<?php
/**
 * Check whether a required plugin class is available.
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
    echo esc_html( 'This feature requires WooCommerce to be installed and active.' );
    echo '</p></div>';
}
