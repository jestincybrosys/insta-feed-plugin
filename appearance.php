<?php
// Sub Menu Page
function sqf_add_submenu_page_callback()
{
    add_submenu_page(
        'sqf-settings',
        __('Appearance', 'social-quick-feed'),
        __('Appearance', 'social-quick-feed'),
        'manage_options',
        'sqf-sub-settings',
        'submenu_page_callback'
    );
}
 
function submenu_page_callback()
{
?>
    <div class="wrap">
        <div class="sqf-contain">
            <div class="row views">
                <div class="col-md-6">
                    <form method="post" action="options.php">
                        <?php
                        // Output nonce, action, and settings fields
                        settings_fields('sqf_my_instagram_feed_settings');
                        do_settings_sections('sqf_my_instagram_feed_settings');
                        ?>
                        <?php
                        submit_button('Update');
                        ?>
                    </form>
                </div>
                <div class="col-md-6">
                    <?php
                    echo _e(do_shortcode('[sqf_feed]'));
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>