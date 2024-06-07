<?php

function dashboard_to_dev_scripts()
{
    wp_enqueue_script('dashboard-to-dev-script', plugin_dir_url(__FILE__) . '../js/dashboard-to-dev-form.js', ['jquery'], '1.0', true);
    wp_localize_script('dashboard-to-dev-script', 'dashboardToDevAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);
}

add_action('admin_enqueue_scripts', 'dashboard_to_dev_scripts');
