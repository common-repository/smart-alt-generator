<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_menu', 'smartaltgen_generator_menu');
add_action('admin_init', 'smartaltgen_generator_settings_init');

function smartaltgen_generator_menu() {
    add_options_page(
        'Smart Alt Generator Settings', 
        'Smart Alt Generator', 
        'manage_options', 
        'smart-alt-generator', 
        'smartaltgen_generator_options_page'
    );
}

function smartaltgen_generator_settings_init() {
    register_setting('smart-alt-generator', 'smartaltgen_generator_settings');

    add_settings_section(
        'smartaltgen_generator_section', 
        'Smart Alt Generator Settings', 
        'smartaltgen_generator_section_callback', 
        'smart-alt-generator'
    );

    add_settings_field(
        'smartaltgen_generator_api_key', 
        'API Key', 
        'smartaltgen_generator_api_key_field_callback', 
        'smart-alt-generator', 
        'smartaltgen_generator_section'
    );

    add_settings_field(
        'smartaltgen_generator_language', 
        'Language', 
        'smartaltgen_generator_language_field_callback', 
        'smart-alt-generator', 
        'smartaltgen_generator_section'
    );
}

function smartaltgen_generator_section_callback() {
    echo 'Enter your settings below:';
}

function smartaltgen_generator_api_key_field_callback() {
    $options = get_option('smartaltgen_generator_settings');
    $api_key = isset($options['api_key']) ? $options['api_key'] : '';
    ?>
    <input type="text" name="smartaltgen_generator_settings[api_key]" style="width: 400px;" value="<?php echo esc_attr($api_key); ?>">
    <p class="description">You can find your API key in your account on <a href="https://smart-alt.com/" target="_blank">https://smart-alt.com/</a>.</p>
    <?php
}

function smartaltgen_generator_language_field_callback() {
    $options = get_option('smartaltgen_generator_settings');
    $selected_language = isset($options['language']) ? $options['language'] : 'en';

    ?>
    <select name="smartaltgen_generator_settings[language]">
        <option value="en" <?php selected($selected_language, 'en'); ?>>English</option>
        <option value="es" <?php selected($selected_language, 'es'); ?>>Spanish</option>
        <option value="zh" <?php selected($selected_language, 'zh'); ?>>Chinese</option>
        <option value="hi" <?php selected($selected_language, 'hi'); ?>>Hindi</option>
        <option value="ar" <?php selected($selected_language, 'ar'); ?>>Arabic</option>
        <option value="fr" <?php selected($selected_language, 'fr'); ?>>French</option>
        <option value="ru" <?php selected($selected_language, 'ru'); ?>>Russian</option>
        <option value="pt" <?php selected($selected_language, 'pt'); ?>>Portuguese</option>
        <option value="de" <?php selected($selected_language, 'de'); ?>>German</option>
        <option value="ja" <?php selected($selected_language, 'ja'); ?>>Japanese</option>
        <option value="it" <?php selected($selected_language, 'it'); ?>>Italian</option>
    </select>
    <?php
}

function smartaltgen_generator_options_page() {
    ?>
    <div class="wrap">
        <h1>Smart Alt Generator Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('smart-alt-generator');
            do_settings_sections('smart-alt-generator');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
