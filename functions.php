<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function  smartaltgen_generate_alt_text($image_url, $keywords) {
    $options = get_option('smartaltgen_generator_settings');
    $api_key = isset($options['api_key']) ? $options['api_key'] : '';
    $language = isset($options['language']) ? $options['language'] : 'en'; 
    if (!$api_key) {
        return false;
    }

    $request_data = wp_json_encode(['url' => $image_url, 'keywords' => $keywords, 'lang' => $language]);

    $response = wp_remote_post('https://smart-alt.com/genimgdesc/', array(
        'method'    => 'POST',
        'body'      => $request_data,
        'headers'   => array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
            'Referer'       => 'https://smart-alt.com/'
        ),
    ));

    if (is_wp_error($response)) {
        return false;
    }

    $response_body = wp_remote_retrieve_body($response);

    $response_data = json_decode($response_body, true);
    if (isset($response_data['status']) && $response_data['status'] == 'OK') {
        return isset($response_data['description']) ? $response_data['description'] : false;
    } else {
        return false;
    }
}
