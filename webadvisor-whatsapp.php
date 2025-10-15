<?php
/*
Plugin Name: Web Advisor WhatsApp Chat Button
Plugin URI: https://webadvisorlk.com/
Description: Floating WhatsApp chat button with customizable options
Version: 1.0
Author: Web Advisor | Themiya Jayakodi
Author URI: https://webadvisorlk.com/
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) exit;

require plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/themiya125/Web-Advisor-Whats-App/',
    __FILE__,
    'webadvisor-whatsapp'
);

// Optional: specify branch (if not main)
$updateChecker->setBranch('main');


// -------------------------
// Admin styles
// -------------------------
add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style(
        'webadvisor-admin-style',
        plugin_dir_url(__FILE__) . 'admin-style.css'
    );
});

// -------------------------
// Load Composer autoload
// -------------------------
if ( file_exists( plugin_dir_path(__FILE__) . 'vendor/autoload.php' ) ) {
    require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
} else {
    add_action('admin_notices', function() {
        echo '<div class="error"><p><strong>Web Advisor WhatsApp Plugin:</strong> Vendor autoload not found. Run <code>composer install</code> in the plugin folder.</p></div>';
    });
    return;
}

// -------------------------
// Boot Carbon Fields
// -------------------------
\Carbon_Fields\Carbon_Fields::boot();

// -------------------------
// Include settings fields
// -------------------------
require_once plugin_dir_path(__FILE__) . 'includes/fields.php';

// -------------------------
// Enqueue frontend styles
// -------------------------
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('webadvisor-whatsapp-style', plugin_dir_url(__FILE__) . 'style.css');
});

// -------------------------
// Display floating WhatsApp button
// -------------------------
add_action('wp_footer', function() {

    if ( ! function_exists('carbon_get_theme_option') ) return;

    $enabled  = carbon_get_theme_option('wa_enable_button');
    if ( ! $enabled ) return;

    $number = carbon_get_theme_option('wa_phone_number');
    if ( empty($number) ) return;

    $message  = urlencode( carbon_get_theme_option('wa_default_message') );
    $position = carbon_get_theme_option('wa_position');
    $color    = carbon_get_theme_option('wa_button_color');
    $size     = floatval( carbon_get_theme_option('wa_button_size') ); // always cast to float

 $use_icon = carbon_get_theme_option('wa_use_custom_icon'); // true/false
$icon_text = carbon_get_theme_option('wa_icon_text'); // emoji/text


if ( $use_icon && ! empty($icon_text) ) {
    $icon = esc_html( $icon_text ); // show emoji/text
} else {
    $icon_size = $size * 0.6;
    $icon = '<img src="' . plugin_dir_url(__FILE__) . 'images/whatsapp-logo.png" alt="WhatsApp" style="width:' . $icon_size . 'px;height:' . $icon_size . 'px;" />';
}


    $url = "https://wa.me/{$number}?text={$message}";
    ?>
    <a href="<?php echo esc_url($url); ?>"
       target="_blank"
       class="wa-floating-btn <?php echo esc_attr($position); ?>"
       style="background:<?php echo esc_attr($color); ?>; width:<?php echo esc_attr($size); ?>px; height:<?php echo esc_attr($size); ?>px;">
       <?php echo $icon; ?>
    </a>
    <?php
});
