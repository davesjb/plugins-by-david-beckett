<?php

class Cfs_admin_form
{
    const ID = 'cfs-admin-form';

    public function init()
    {
        add_action('admin_menu', array($this, 'add_menu_page'), 20);
    }
    public function get_id()
    {
        return self::ID;
    }

    public function add_menu_page()
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

    function load_view()
    {
        $this->default_values = $this->get_defaults();
        $this->current_page = ct_admin_current_view();

        $current_views = isset($this->views[$this->current_page]) ? $this->views[$this->current_page] : $this->views['not-found'];
        $step_data_func_name = $this->current_page . '_data';
        $args = [];

        /* Prepare data for view*/
        if (method_exists($this, $step_data_func_name)) {
            $args = $this->$step_data_func_name();
        }
        /**
         * Default Admin Form Template
         */
        echo '<div class="ct-admin-forms ' . $this->current_page . '">';
        echo '<div class="container container1">';
        echo '<div class="inner">';
        $this->includeWithVariables(ct_admin_template_server_path('views/alerts', false));
        $this->includeWithVariables(ct_admin_template_server_path($current_views, false), $args);
        echo '</div>';
        echo '</div>';
        echo '</div> <!-- / ct-admin-forms -->';
    }

    function includeWithVariables($filePath, $variables = array(), $print = true)
    {
        $output = NULL;
        if (file_exists($filePath)) {
            extract($variables);

            ob_start();

            include $filePath;

            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;
    }
}
