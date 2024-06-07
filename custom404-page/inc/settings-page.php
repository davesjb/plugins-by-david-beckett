<div class="wrap">
    <h1>Custom 404 Page Settings</h1>
    <form action="options.php" method="post">
        <?php settings_fields('custom404-page-settings-group') ?>
        <?php do_settings_sections('custom404-page-settings') ?>
        <?php submit_button() ?>

    </form>
</div>