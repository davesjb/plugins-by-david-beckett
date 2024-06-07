<?php

if (!defined('WPINC')) {
    die;
}

function wp_head_code_output()
{
    echo get_option('wp_head_code');
}

add_action('wp_head', 'wp_head_code_output');


function wp_footer_code_output()
{
    echo get_option('wp_footer_code');
}

add_action('wp_footer', 'wp_footer_code_output');
