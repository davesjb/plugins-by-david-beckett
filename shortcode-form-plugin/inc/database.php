<?php

function shortcode_form_plugin_table()
{
    global $wpdb; //Connects db

    $table_name = $wpdb->prefix . 'shortcode_form_plugin';
    $charset_collate =  $wpdb->get_charset_collate();

    $columns = [
        'id' => 'mediumint(9) NOT NULL AUTO_INCREMENT',
        'fullname' => 'varchar(50) NOT NULL',
        'email' => 'varchar(100) NOT NULL',
        'phone' => 'varchar(15) NOT NULL',
        'message' => 'text',
        'date_submitted' => 'datetime DEFAULT CURRENT_TIMESTAMP NOT NULL'

    ];


    if ($wpdb->get_var("SHOW TABLE LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            fullname varchar(50) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(15) NOT NULL,
            message text,
            date_submitted datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    } else {
        $existing_columns =  $wpdb->get_call("DESC $table_name", 0);

        if (!in_array('date_submitted', $existing_columns)) {
            $sql = "ALTER TABLE $table_name ADD COLUMN date_submitted datetime DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER message;";
            $wpdb->query($sql);
        }
    }
}

register_activation_hook(__FILE__, 'shortcode_form_plugin_table');
