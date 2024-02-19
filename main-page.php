<?php 
ob_start();
session_start();

// Plugin Settings Main Page
function sqf_settings_page()
{
    //Account removed notification
    if (isset($_GET['status']) == 'success') {
?>
        <div class="bg-danger insta-del mt-2">
            <?php
            echo _('Account removed successfully');
            ?>
            <a href="<?php echo home_url() . '/wp-admin/admin.php?page=sqf-settings' ?>">
                <span class="dashicons dashicons-dismiss"></span>
            </a>
        </div>
    <?php
    }

    //Instagram login button
    $access_token_with_id = get_option('sqf_save_instagram_access_token');
    if (!$access_token_with_id) {
    ?>
        <div class="login-button-contain">
            <div class="login-img">
                <img src="<?php echo plugin_dir_url(__FILE__) ?>/assets/images/add-new.svg" alt="">
            </div>
            <div class="login-add">
                <span>Add Account</span>
            </div>
            <div class="login-desc">
                <span>Please click the button below to authorize Social Quick Feed to access your Instagram account</span>
            </div>
            <?php
            echo _e(do_shortcode('[instagram-login]'));
            ?>
        </div>
        <?php
    } else {
        ' ';
    }

    $feed = sqf_get_instagram_feed();
    if ($feed) {
        $username = $feed[0]->username;
        $user_Id = $feed[0]->id;
        $access_token_with_id = get_option('sqf_save_instagram_access_token');
        $access_token = $access_token_with_id['access_token'];
        $validation_id = $access_token_with_id['val_id'];
        // Instagram Account
        if ($access_token_with_id) {
        ?>
            <section class="insta-accounts">
                <div class="sqf-contain">
                    <div class="heading-and-btn">
                        <div class="heading">
                            <h1>Instagram Accounts</h1>
                        </div>
                        <div class="add-new-btn-div">
                            <?php
                            $return_in_new = home_url() . '/wp-admin/admin.php?page=sqf-settings';
                            $site_uri_in_new = "https://insta-feeds-app.000webhostapp.com/Auth?login=true&return={$return_in_new}";
                            ?>
                            <a href="<?php echo esc_attr__($site_uri_in_new, 'social-quick-feed')  ?>" class="sqf-add-new-btn">Add New</a>
                        </div>
                    </div>
                </div>
            </section>
        <?php
        }
        if ($access_token_with_id) {
        ?>
            <div class="social-wrapper">
                <div class="sqf-contain">
                    <table class="widefat fixed" cellspacing="0">
                        <thead>
                            <tr>
                                <th id="columnname" class="manage-column column-columnname" scope="col">Username</th>
                                <th id="columnname" class="manage-column column-columnname" scope="col">User ID</th>    
                                <th id="columnname" class="manage-column column-columnname" scope="col">Access Token</th>
                                <th id="columnname" class="manage-column column-columnname" scope="col">ShortCode</th>

                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th id="columnname" class="manage-column column-columnname" scope="col">Username</th>
                                <th id="columnname" class="manage-column column-columnname" scope="col">User ID</th>
                                <th id="columnname" class="manage-column column-columnname" scope="col">Access Token</th>
                                <th id="columnname" class="manage-column column-columnname" scope="col">ShortCode</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            <tr>
                                <th class="check-column" scope="row"></th>
                            </tr>
                            <tr class="alternate" valign="top">
                                <td class="column-columnname">
                                    <?php
                                    if (is_array($access_token_with_id)) {
                                        echo '<div class= "access-input">
                                                    <a href= "https://www.instagram.com/' . esc_attr__($username) . '">' . _e($username) . '</span>
                                              </div>';
                                    } else {
                                        ' ';
                                    }
                                    ?>
                                    <div class="accnt-icons">
                                        <?php if ($access_token_with_id) : ?>
                                            <a title="Appearance" href="<?php echo admin_url('admin.php?page=sqf-sub-settings') ?>">
                                                <span class="settings text-primary">Edit</span>
                                            </a>
                                            <span class="vertical-bar">|</span>
                                            <a class="remove" title="Remove" href="<?php echo admin_url('admin.php?page=sqf-settings&val_id=' . $validation_id); ?>" name="remove_account_btn">
                                                <?php
                                                if (isset($_GET['val_id'])) {
                                                    $user_id = $_GET['val_id'];
                                                    $id = $access_token_with_id['val_id'];
                                                    // Delete the option that stores the access token for the Instagram account
                                                    if ($id == $user_id) {
                                                        delete_option("sqf_save_instagram_access_token");
                                                        delete_option("sqf_my_instagram_feed_view_type");
                                                        delete_option("sqf_grid_columns");
                                                        delete_option("sqf_my_instagram_feed_height");
                                                        delete_option("sqf_my_instagram_feed_width");
                                                        delete_option("sqf_my_instagram_border_radius");
                                                        delete_option("sqf_my_instagram_username");
                                                        delete_option("sqf_instagram_post_limit");
                                                        delete_option("sqf_display_profile_checkbox");
                                                        delete_option("sqf_display_profile_text");
                                                        delete_option("sqf_my_instagram_feed_profile_place");
                                                        delete_option("sqf_instagram_icon_field");
                                                        delete_option("sqf_scrollable_container_height");
                                                        delete_option("sqf_scrollable_columns");
                                                        delete_option("sqf_carousel_columns");
                                                        delete_option("sqf_carousel_time_interval");
                                                        delete_option("sqf_carousel_view_type");
                                                        delete_option("sqf_carousel_left_arrow");
                                                        delete_option("sqf_carousel_right_arrow");
                                                        delete_option("sqf_carousel_shade_field");
                                                        delete_option("sqf_my_plugin_color");
                                                    }
                                                    header('Location:' . home_url() . '/wp-admin/admin.php?page=sqf-settings&status=success');
                                                }
                                                ?>
                                                <span class="remove text-danger">Remove</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php
                        } else {
                            ' ';
                        }
                            ?>
                            <td class="column-columnname">
                                <?php
                                if (is_array($access_token_with_id)) {
                                    echo esc_attr($user_Id);
                                ?>
                            </td>
                            <td class=" column-columnname">
                                <?php
                                    if (is_array($access_token_with_id)) {
                                        echo    '<div class= "access-input">
                                                    <input readonly id="myInput" type="text" name="sqf_save_instagram_access_token" value="' . esc_attr($access_token) . '">
                                                    <span class="dashicons dashicons-admin-page sqf-copy-code" onclick="accesstokenFunction()"></span>
                                                </div>';
                                    } else {
                                        ' ';
                                    }
                                ?>
                            </td>
                            <td class="column-columnname">
                                <?php
                                    if (is_array($access_token_with_id)) {
                                        echo '<div class= "access-input">
                                                <input readonly id="shortcodeInput" type="text"  value="' . esc_attr('[sqf_feed]') . '">
                                                <span class="dashicons dashicons-admin-page sqf-copy-code" onclick="shortcodeFunction()"></span>
                                                </div>';
                                    } else {
                                        ' ';
                                    }
                                ?>
                            </td>
                            </tr>
                            <tr valign="top">
                                <th class="check-column" scope="row"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            }
        }
    }
?>