<?php

function qrcode_settings_options(){
    add_settings_section('qrcode_settings', __('QRCode Section', 'word-count'), 'qrcode_section', 'general');

    // Seetings fields
    add_settings_field('qrcode_show_options', __('Show QR code', 'word-count'), 'qrcode_showing_option', 'general', 'qrcode_settings');
    add_settings_field('qrcode_width', __('QRCode Width', 'word-count'), 'qrocode_width', 'general', 'qrcode_settings');
    add_settings_field('qrcode_height', __('QRCode Height', 'word-count'), 'qrocode_height', 'general', 'qrcode_settings');



    // Register settings
    register_setting('general', 'qrcode_show_options', array('sanitize_callback' => 'esc_attr'));
    register_setting('general', 'qrcode_width', array('sanitize_callback' => 'esc_attr'));
    register_setting('general', 'qrcode_height', array('sanitize_callback' => 'esc_attr'));
}

function qrcode_section(){
    echo '<p>QRCode settings for post and page</p>';
}

function qrcode_showing_option(){
    $show_qrcode = get_option('qrcode_show_options');
        $page = '<label><input type="checkbox" name="qrcode_show_options[qrpage]" value="1"'. checked(1, $show_qrcode["qrpage"], false). ' /> Page</label>';

    echo $page;
}
function qrocode_width(){
    $width = get_option('qrcode_width');
    printf('<input type="text" id="%s" name="%s" value="%s"/>', 'qrcode_width', 'qrcode_width', $width);
}

function qrocode_height(){
    $height = get_option('qrcode_height');
    printf('<input type="text" id="%s" name="%s" value="%s" />', 'qrcode_height', 'qrcode_height', $height);
}


add_action('admin_init', 'qrcode_settings_options');
