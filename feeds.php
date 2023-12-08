<?php
// Check if the access token is set in the URL
if (isset($_GET['access_token'])) {
    // Retrieve the access token from the URL query parameters
    $access_token = $_GET['access_token'];
    $validation_id = bin2hex(random_bytes(16));
    urldecode($access_token);
    $access_token_with_id = update_option(
        'sqf_save_instagram_access_token',
        array(
            'access_token' => $access_token,
            'val_id'  => $validation_id,
        )
    );

    header('Location:' . home_url() . '/wp-admin/admin.php?page=sqf-settings');
    // print_r($access_token);
}

// Get the Instagram access token and retreive the posts
function sqf_get_instagram_feed()
{
    $access_token_with_id = get_option('sqf_save_instagram_access_token');
    if ($access_token_with_id) {
        $access_token = $access_token_with_id['access_token'];
        $url = 'https://graph.instagram.com/me/media?fields=id,username,caption,media_type,media_url,permalink,thumbnail_url,timestamp&access_token=' . $access_token;
        $response = wp_remote_get($url);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        // print_r($data);
        return $data->data;
    }
} 
