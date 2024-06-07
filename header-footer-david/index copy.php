<?php

/*
 * removed
 * 
 */

if (!defined('WPINC')) {
    die;
}

// Menu
function header_footer_page()
{
    add_menu_page(
        'Snips',
        'Snips',
        'manage_options',
        'wpplugin',
        'wpplugin_settings_page_markup',
        'dashicons-wordpress-alt',
        110
    );
}

add_action('admin_menu', 'header_footer_page');



function hfd_settings_init()
{
    $hfd_settings = hfd_settings();


    add_settings_section(
        'head_footer_code_settings_sitewide',
        __('Site-wide head, body and footer code', 'head-footer-code'), // Title.
        'auhfc_sitewide_settings_section_description',                            // Callback.
        HFC_PLUGIN_SLUG                                                        // Page.
    );


    add_settings_field(
        'hfd_head_code',                        //ID
        esc_html('Head', 'head-footer-code'),   //Title
        'hfd_number_field',                     //Callback
        HFD_PLUGIN_SLUG,                        //Page
        'hfd_header_footer_code_settings_sitewide',      //Section
        array( //Auguments
            'field'         => 'hfd_settings_sitewide[head]',
            'label_for'     => 'hfd_settings_sitewide[head]',
            'label'         => __('HEAD Code', 'head-footer-code'),
            'value'       => $hfd_settings['sitewide']['head'],
            'description' => $head_note . sprintf(
                /* translators: %s will be replaced with preformatted HTML tag </head> */
                __('Code to enqueue in HEAD section (before the %s).', 'head-footer-code'),
                auhfc_html2code('</head>')
            ),
            'field_class' => 'widefat code codeEditor',
            'rows'        => 7,

        )

    );
}


// Dark mode

// Test mode
