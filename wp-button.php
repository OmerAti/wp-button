<?php
/*
Plugin Name: WhatsApp Buton Eklentisi
Plugin URI: https://www.jrodix.com
Description: WhatsApp Buton Ikonu Ekleme
Version: 1.0
Author: Ömer ATABER - OmerAti 
Author URI: https://www.jrodix.com
*/

function add_whatsapp_callback_html() {
    $phone_number = get_option('whatsapp_callback_phone_number');
    $button_position = get_option('whatsapp_callback_button_position');
    $whatsapp_message = get_option('whatsapp_callback_message');
    
    ?>
    <div id="capitol-callback" style="left: <?php echo $button_position === 'left' ? '40px' : 'auto'; ?>; right: <?php echo $button_position === 'right' ? '40px' : 'auto'; ?>;">
        <div class="cpt-circle"></div>
        <div class="cpt-circle-fill"></div>
        <a href="https://wa.me/<?php echo esc_attr($phone_number); ?>/?text=<?php echo esc_attr($whatsapp_message); ?>" id="WhatsAppBtnDesktop" target="_blank" class="main-button" lang="en">
            <img src="<?php echo plugin_dir_url(__FILE__) . 'WhatsApp.png'; ?>" width="50%">
        </a>
    </div>
    <?php
}
add_action('wp_footer', 'add_whatsapp_callback_html');

function add_whatsapp_callback_styles() {
    wp_enqueue_style('whatsapp-callback-styles', plugin_dir_url(__FILE__) . 'wp.css');
}
add_action('wp_enqueue_scripts', 'add_whatsapp_callback_styles');

function add_whatsapp_callback_settings() {
    add_options_page('WhatsApp Buton Ayarları', 'WhatsApp Buton', 'manage_options', 'whatsapp-callback-settings', 'whatsapp_callback_settings_page');
}
add_action('admin_menu', 'add_whatsapp_callback_settings');

function whatsapp_callback_settings_page() {
    ?>
    <div class="wrap">
        <h2>WhatsApp Buton Ayarları</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('whatsapp_callback_settings_group');
            do_settings_sections('whatsapp-callback-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function whatsapp_callback_settings_init() {
    register_setting('whatsapp_callback_settings_group', 'whatsapp_callback_phone_number');
    register_setting('whatsapp_callback_settings_group', 'whatsapp_callback_button_position');
    register_setting('whatsapp_callback_settings_group', 'whatsapp_callback_message');

    add_settings_section('whatsapp_callback_setting_section', 'WhatsApp Geri Arama Ayarları', 'whatsapp_callback_section_callback', 'whatsapp-callback-settings');
    add_settings_field('whatsapp_callback_phone_number_field', 'Telefon Numarası', 'whatsapp_callback_phone_number_field_render', 'whatsapp-callback-settings', 'whatsapp_callback_setting_section');
    add_settings_field('whatsapp_callback_button_position_field', 'Buton Pozisyonu', 'whatsapp_callback_button_position_field_render', 'whatsapp-callback-settings', 'whatsapp_callback_setting_section');
    add_settings_field('whatsapp_callback_message_field', 'WhatsApp Mesajı', 'whatsapp_callback_message_field_render', 'whatsapp-callback-settings', 'whatsapp_callback_setting_section');
}
add_action('admin_init', 'whatsapp_callback_settings_init');

function whatsapp_callback_section_callback() {
    echo '<p>Bu ayarlar WhatsApp geri arama butonu için gereklidir.</p>';
}

function whatsapp_callback_phone_number_field_render() {
    $phone_number = get_option('whatsapp_callback_phone_number');
    echo '<input type="text" name="whatsapp_callback_phone_number" value="' . esc_attr($phone_number) . '" />';
}

function whatsapp_callback_button_position_field_render() {
    $button_position = get_option('whatsapp_callback_button_position');
    ?>
    <select name="whatsapp_callback_button_position">
        <option value="left" <?php selected($button_position, 'left'); ?>>Solda</option>
        <option value="right" <?php selected($button_position, 'right'); ?>>Sağda</option>
    </select>
    <?php
}

function whatsapp_callback_message_field_render() {
    $whatsapp_message = get_option('whatsapp_callback_message');
    echo '<input type="text" name="whatsapp_callback_message" value="' . esc_attr($whatsapp_message) . '" />';
}
