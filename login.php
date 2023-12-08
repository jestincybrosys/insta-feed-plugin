<?php
// Your Instagram app's credentials
// $client_id = '269542565397880';
// $client_secret = '2cae934ea5ecdbfe9b521b293349c662';
// $redirect_uri = 'YOUR_REDIRECT_URI';

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