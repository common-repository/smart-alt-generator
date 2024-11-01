<?php
/**
 * Plugin Name: Smart Alt Generator
 * Plugin URI: https://smart-alt.com/
 * Description: Automatically generates alt text for images on your site using an external API, improving accessibility and SEO.
 * Version: 1.0
 * Author: Ash Tools
 * Author URI:
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


require_once plugin_dir_path(__FILE__) . 'settings.php';
require_once plugin_dir_path(__FILE__) . 'functions.php';

add_filter('wp_generate_attachment_metadata', 'smartaltgen_update_image_alt_text', 10, 2);

function smartaltgen_update_image_alt_text($metadata, $attachment_id) {
    $options = get_option('smartaltgen_generator_settings');
    $language = isset($options['language']) ? $options['language'] : 'en'; // Default to English
    $use_keywords = isset($options['use_keywords']) && $options['use_keywords'];

    $image_url = wp_get_attachment_url($attachment_id);

    $keywords = $use_keywords ? extract_keywords_from_post($attachment_id) : [];

    $alt_text =  smartaltgen_generate_alt_text($image_url, $keywords, $language);

    if (!empty($alt_text)) {
        $result = update_post_meta($attachment_id, '_wp_attachment_image_alt', sanitize_text_field($alt_text));
    }

    return $metadata;
}
