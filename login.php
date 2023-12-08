<?php
// create shortcode for account login
function sqf_login_with_insta()
{
    $return = home_url() . '/wp-admin/admin.php?page=sqf-settings';
    // print_r($return);
    $site_uri = "https://insta-feeds-app.000webhostapp.com/Auth?login=true&return={$return}";
    // print_r($site_uri);
    echo
    '<a  href="' . $site_uri . '" class = ' . "login-btn" . '>
            <span class="dashicons dashicons-instagram"></span>
            <span>Sign in with Instagram</span>
        </a>';
}
?> 