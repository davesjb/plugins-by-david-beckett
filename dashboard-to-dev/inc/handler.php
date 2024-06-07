<?php

function dashboard_ajax_handler()
{
    if (isset($_POST['action']) && $_POST['action'] == 'dashboard_submit') {

        // wp_die("hi");

        $errors = [];

        // Sanitize task field
        $task = isset($_POST['task']) ? sanitize_text_field($_POST['task']) : '';
        if (empty($task)) {
            $errors[] = 'Task name is required';
        }

        // Sanitize page field
        $page = isset($_POST['page']) ? sanitize_text_field($_POST['page']) : '';

        // Sanitize priority field
        $priority = isset($_POST['priority']) ? sanitize_text_field($_POST['priority']) : '';

        // Sanitize due date field
        $due_date = isset($_POST['due_date']) ? sanitize_text_field($_POST['due_date']) : '';

        // Sanitize date submitted field
        // $date_submitted = isset($_POST['date_submitted']) ? sanitize_text_field($_POST['date_submitted']) : '';

        if (empty($errors)) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'dashboard_to_dev';
            $result = $wpdb->insert($table_name, [
                'task' => $task,
                'page' => $page,
                'priority' => $priority,
                'due_date' => $due_date,
                'date_submitted' => current_time('mysql')

            ]);
            if ($result) {
                echo json_encode(['success' => true, 'message' => "Form submitted successfully"]);
            } else {
                echo json_encode(['success' => false, 'message' => "Failed to submit form"]);
            }
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
        }
    }
}
add_action('wp_ajax_dashboard_submit', 'dashboard_ajax_handler');
add_action('wp_ajax_nopriv_dashboard_submit', 'dashboard_ajax_handler');
