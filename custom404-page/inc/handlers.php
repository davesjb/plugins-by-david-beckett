<?php

if (!defined('WPINC')) {
    die;
}

function custom404_page_handler()
{
    if (is_404()) {
        $message = get_option('custom404_page_message', 'Oops page not found!');
        $redirect = get_option('custom404_page_redirect');
        if (!empty($redirect)) {
            wp_redirect($redirect);
            exit;
        } else {
            status_header(404);
            echo $message;
            exit;
        }
    }
}

add_action('template_redirect', 'custom404_page_handler');
