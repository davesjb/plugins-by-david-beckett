<?php

function shortcode_form_plugin_shortcode()
{
    include(plugin_dir_path(__FILE__) . 'shortcode-page.php');
}

add_shortcode('shortcode-form', 'shortcode_form_plugin_shortcode');


function shortcode_form_plugin_ajax_handler()
{
    // echo "form submitted";
    // wp_die();

    // 

    if (isset($_POST['action']) && $_POST['action'] == 'shortcode_form_plugin_submit') {
        $errors = [];
        $fullname = sanitize_text_field($_POST['fullname']);
        if (empty($fullname)) {
            $errors[] = 'Full name is required';
        }
        $email = sanitize_email($_POST['email']);
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address';
        }



        $phone = sanitize_text_field($_POST['phone']);
        if (empty($phone) || strlen($phone) !== 10 || !ctype_digit($phone)) {
            $errors[] = 'Phone number must be 10 digits';
        }



        $message = sanitize_textarea_field($_POST['message']);


        if (empty($errors)) {

            global $wpdb;
            $table_name = $wpdb->prefix . 'shortcode_form_plugin';
            // wp_die($table_name);
            $result = $wpdb->insert($table_name, [
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
                'date_submitted' => current_time('mysql')

            ]);

            // var_dump($result);
            // die();
            // Reactivate plugin

            // wp_die($result);

            echo json_encode(['success' => true, 'message' => "form submitted successfully"]);
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
        }
    }
}

add_action('wp_ajax_shortcode_form_plugin_submit', 'shortcode_form_plugin_ajax_handler');
add_action('wp_ajax_nopriv_shortcode_form_plugin_submit', 'shortcode_form_plugin_ajax_handler');


function shortcode_form_plugin_menu()
{
    add_menu_page(
        'Shortcode Form',
        'Shortcode Form',
        'manage_options',
        'shortcode-form-plugin-settings',
        'shortcode_form_plugin_settings_page'
    );
}

add_action('admin_menu', 'shortcode_form_plugin_menu');

function shortcode_form_plugin_settings_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'shortcode_form_plugin';


    if (isset($_POST['update_entry'])) {
        $entry_id = intval($_POST['entry_id']);
        $field = $_POST['field'];
        $new_value = sanitize_text_field($_POST['new_value']);
        $valid_fields = ['fullname', 'email', 'phone', 'message'];

        if (!in_array($field, $valid_fields)) {
            wp_die("Invalid field");
        }

        $wpdb->update(
            $table_name,
            [$field => $new_value],
            ['id' => $entry_id],
            ['%s'],
            ['%d']
        );
        wp_die();
    }
    $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'date_submitted';
    $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
    $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';
    $query = "SELECT * FROM $table_name ORDER BY $orderby $order;";

    $entries = $wpdb->get_results($query);

    // wp_die($query);

    // print_r($entries);
    // die;



    include(plugin_dir_path(__FILE__) . 'shortcode-entries.php');
}
