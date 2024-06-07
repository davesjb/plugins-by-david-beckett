<div class="wrap">
    <h2>WP Head and Footer Settings</h2>

    <form action="options.php" method="post">
        <?php settings_fields('wp-head-and-footer-group'); ?>
        <?php do_settings_sections('wp-head-and-footer-group'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Head Code</th>
                <td>
                    <textarea name="wp_head_code" cols="50" rows="5"><?php echo esc_textarea(get_option('wp_head_code'))  ?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Footer Code</th>
                <td>
                    <textarea name="wp_footer_code" cols="50" rows="5"><?php echo esc_textarea(get_option('wp_footer_code'))  ?></textarea>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>