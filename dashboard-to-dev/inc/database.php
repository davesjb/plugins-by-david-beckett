<?php

function dashboard_to_dev_plugin_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'dashboard_to_dev';
    $charset_collate = $wpdb->get_charset_collate();

    // Check if table exists
    if ($wpdb->get_var("SHOW TABLE LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            task varchar(50) NOT NULL,
            page varchar(100) NOT NULL,
            priority ENUM('low', 'medium', 'high') NOT NULL,
            due_date DATE NOT NULL,
            date_submitted datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    } else {
        $existing_columns = $wpdb->get_call("DESC $table_name", 0);

        if (!in_array('date_submitted', $existing_columns)) {
            $sql = "ALTER TABLE $table_name ADD COLUMN date_submitted datetime DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER message;";
            $wpdb->query($sql);
        }
    }
}
// dashboard_to_dev_plugin_table();
// die();


register_activation_hook(__FILE__, 'dashboard_to_dev_plugin_table');
