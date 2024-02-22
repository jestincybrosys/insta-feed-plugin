<?php 

// Check if the access token is set in the URL
if (isset($_GET['access_token'])) {
    // Retrieve the access token from the URL query parameters
    $access_token = $_GET['access_token'];
    urldecode($access_token);
    $access_tokens = get_option('sqf_saved_instagram_access_tokens', array());
    $validation_id = bin2hex(random_bytes(16));

    // Check if the access token already exists
    $existing_token_index = array_search($access_token, array_column($access_tokens, 'access_token'));

    if ($existing_token_index !== false) {
        // If the access token already exists, use its validation ID
        $validation_id = $access_tokens[$existing_token_index]['val_id'];
    } else {
        // If the access token doesn't exist, add it with a new validation ID
        $access_tokens[] = array(
            'access_token' => $access_token,
            'val_id'  => $validation_id,
        );
        update_option('sqf_saved_instagram_access_tokens', $access_tokens);
    }

    header('Location:' . home_url() . '/wp-admin/admin.php?page=sqf-settings');
}

// Get the Instagram access token and retrieve the posts
function sqf_get_instagram_feeds()
{
    $access_tokens = get_option('sqf_saved_instagram_access_tokens', array());
    $feeds = array();
    foreach ($access_tokens as $access_token_with_id) {
        $access_token = $access_token_with_id['access_token'];
        $url = 'https://graph.instagram.com/me/media?fields=id,username,caption,media_type,media_url,permalink,thumbnail_url,timestamp&access_token=' . $access_token;
        $response = wp_remote_get($url);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        if ($data && isset($data->data)) {
            foreach ($data->data as $item) {
                $item->access_token = $access_token; // Assign access_token to each item
                $feeds[] = $item;
            }
        }
    }
    return $feeds;
}

?>