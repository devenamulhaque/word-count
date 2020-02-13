<?php
/**
 * Plugin Name:       Word Count
 * Plugin URI:        https://electronthemes.com/plugins/wordcount/
 * Description:       This is wordcount plugin
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Enamul Haque
 * Author URI:        https://enamul.me/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       word-count
 * Domain Path:       /languages
 */

 function wordcount_register_hook(){}
 register_activation_hook(__FILE__, 'wordcount_register_hook');

 function wordcount_deregister_hook(){}
 register_deactivation_hook(__FILE__, 'wordcount_deregister_hook');

 function wordcount_load_textdomain(){
     load_plugin_textdomain('word-count', false, dirname(__FILE__)."/languages");
 }
 add_action('plugin_loaded', 'wordcount_load_textdomain');


 function wordcount_full_content($content){
    $strip_tags = strip_tags($content);
    $count = str_word_count($strip_tags);

    $labels = __('Total words: ', 'word-count');
    $labels = apply_filters('wordcount_label', $labels);
    $content .= sprintf('<h3>%s %s</h3>', $labels, $count);

    return $content;
 }
 add_filter('the_content', 'wordcount_full_content');


 // QR code Generator
 function qrcode_generator($content){
    // cuurent post ID
    $currentID = get_the_ID();
    //current post title
    $postTitle = get_the_title($currentID);
    // current post URL
    $currentUrl = urlencode(get_the_permalink($currentID));
    // Current Post type
    $current_post_type = get_post_type($currentID);
    // exclude QR code from this
    $exclude_QRCode = apply_filters('exclude_QRCode_post_type', array());

    if(in_array($current_post_type, $exclude_QRCode)){
        return $content;
    }
    $width = get_option('qrcode_width');
    $height = get_option('qrcode_height');
    $width = $width?$width:'150';
    $height = $height?$height:'150';

    $qrcode_option = get_option('qrcode_show_options');
    $qrcode_show = array();
    if(in_array($qrcode_option, $qrcode_show)){
        $qrcode = sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%sx%s&data=%s', $width, $height, $currentUrl);
        $content .= sprintf('<img src="%s" alt="%s">', $qrcode, $postTitle);
        return $content;
    }



 }
 add_filter('the_content', 'qrcode_generator');


 require_once('settings.php');