<?php

function shortcode_form_plugin_scripts()
{
    wp_enqueue_script('shortcode-form-plugin-script', plugin_dir_url(__FILE__) . '../js/shortcode-form-plugin.js', ['jquery'], '1.0', true);
    wp_localize_script('shortcode-form-plugin-script', 'shortcodeFormPluginAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);
}

add_action('wp_enqueue_scripts', 'shortcode_form_plugin_scripts');
