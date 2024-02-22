<?php 
ob_start();
session_start();

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
function sqf_get_instagram_feed()
{
    $access_tokens = get_option('sqf_saved_instagram_access_tokens', array());
    $uniqueUsernames = array(); // Array to store unique usernames
    $feeds = array();
    foreach ($access_tokens as $access_token_with_id) {
        $access_token = $access_token_with_id['access_token'];
        $url = 'https://graph.instagram.com/me/media?fields=id,username,caption,media_type,media_url,permalink,thumbnail_url,timestamp&access_token=' . $access_token;
        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            // Handle error response
            error_log('Error fetching Instagram data: ' . $response->get_error_message());
            continue; // Move to the next access token
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        if ($data && isset($data->data)) {
            foreach ($data->data as $item) {

                // Check if the username is unique
                if (!in_array($item->username, $uniqueUsernames)) {
                    $uniqueUsernames[] = $item->username; // Add username to the list of unique usernames
                    $item->access_token = $access_token; // Assign access_token to each item
                    $item->val_id = $access_token_with_id['val_id']; // Assign val_id to each item
                    $feeds[] = $item;
                }
            }
        }
    }
    return $feeds;
}

// Generate unique shortcode for each user
function generate_unique_shortcode($username, $access_token) {
    // Concatenate username and access token to create a unique identifier
    $unique_identifier = $username . '_' . substr(md5($access_token), 0, 8);
    // Append the unique identifier to the base shortcode
    $shortcode = '[sqf_feed_' . $unique_identifier . ']';
    return $shortcode;
}

// Register shortcode callback function
function custom_instagram_shortcode_callback($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'username' => '', // Default username
        'access_token' => '' // Default access token
    ), $atts);

    // Check if username and access token are provided
    if (!empty($atts['username']) && !empty($atts['access_token'])) {
        // Generate unique shortcode based on username and access token
        $shortcode = generate_unique_shortcode($atts['username'], $atts['access_token']);
        return $shortcode;
        echo $shortcode;

    } else {
        return 'Invalid shortcode parameters'; // Error message if parameters are missing
    }
}
// Register shortcode
add_shortcode('custom_instagram_shortcode', 'custom_instagram_shortcode_callback');


// Plugin Settings Main Page
function sqf_settings_page()
{
    // Account removed notification
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        ?>
        <div class="bg-danger insta-del mt-2">
            <?php echo _('Account removed successfully'); ?>
            <a href="<?php echo home_url() . '/wp-admin/admin.php?page=sqf-settings' ?>">
                <span class="dashicons dashicons-dismiss"></span>
            </a>
        </div>
        <?php
    }

    // Instagram login button
    $access_tokens = get_option('sqf_saved_instagram_access_tokens', array());
    if (empty($access_tokens)) {
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
            <?php echo _e(do_shortcode('[instagram-login]')); ?>
        </div>
        <?php
    }

    $feed = sqf_get_instagram_feed();
    if (!empty($feed)) {
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
                        <a href="<?php echo esc_attr__($site_uri_in_new, 'social-quick-feed') ?>" class="sqf-add-new-btn">Add New</a>
                    </div>
                </div>
            </div>
        </section>
        <div class="social-wrapper">
            <div class="sqf-contain">
                <div class="widefat sqf-card-head fixed d-grid" cellspacing="0">

                        <?php foreach ($feed as $item) : ?>
                            <div class=" sqf-main-card">
                                <div class="sqf-card-inner-line">

                                   <a href="<?php echo admin_url('admin.php?page=sqf-sub-settings') ?>"> <h5><?php echo esc_html($item->username); ?></h5></a>
                                </div>
                    <p>access token</p>
                    <div>
                        <input type="text" id="access_token_<?php echo esc_attr($item->username); ?>" value="<?php echo esc_attr($item->access_token); ?>" readonly>
                        <button id="copyButton_access_<?php echo esc_attr($item->username); ?>" onclick="copyToClipboard('access_token_<?php echo esc_attr($item->username); ?>', 'copyButton_access_<?php echo esc_attr($item->username); ?>')"> <span class="dashicons dashicons-admin-page sqf-copy-code" ></span></button>
                    </div>
                    <p>shortcode</p>
                    <div>
                        <input type="text" id="shortcode_<?php echo esc_attr($item->username); ?>" value="<?php echo esc_attr(generate_unique_shortcode($item->username, $item->access_token)); ?>" readonly>
                        <button id="copyButton_shortcode_<?php echo esc_attr($item->username); ?>" onclick="copyToClipboard('shortcode_<?php echo esc_attr($item->username); ?>', 'copyButton_shortcode_<?php echo esc_attr($item->username); ?>')"><span class="dashicons dashicons-admin-page sqf-copy-code" ></span></button>
                    </div>

                
                    <div class="sqf-card-inner-t-line">
                    <a title="Appearance" href="<?php echo admin_url('admin.php?page=sqf-sub-settings') ?>">
                        <span class="settings text-primary">Edit</span>
                    </a>   
                        <a href="<?php echo admin_url('admin.php?page=sqf-settings&remove_val_id=' . $item->val_id); ?>"> <span class="remove text-danger">Remove</span></a>
                    </div>                         
                </div>
            <?php endforeach; ?>
                </div>
            </div>
        </div>
        <script>
                         function copyToClipboard(elementId, buttonId) {
    var copyText = document.getElementById(elementId);
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    document.execCommand("copy");
    var button = document.getElementById(buttonId); // Get the button element
    button.innerHTML = `<span class="dashicons dashicons-yes sqf-copy-code-scc"></span>`; // Change the button text to "Copied"
    setTimeout(function() {
        button.innerHTML = `<span class="dashicons dashicons-admin-page sqf-copy-code" ></span>`; // Reset the button text to "Copy" after 2 seconds
    }, 2000); // Hide the popup after 2 seconds
}


</script>
        <?php
    }
}

// Remove Instagram Account
if (isset($_GET['remove_val_id'])) {
    $val_id = $_GET['remove_val_id'];
    $access_tokens = get_option('sqf_saved_instagram_access_tokens', array());
    foreach ($access_tokens as $key => $access_token) {
        if ($access_token['val_id'] === $val_id) {
            unset($access_tokens[$key]);
            update_option('sqf_saved_instagram_access_tokens', $access_tokens);
            header('Location:' . home_url() . '/wp-admin/admin.php?page=sqf-settings&status=success');
            exit;
        }
    }
}

// Edit Instagram Account (not implemented fully, you can adjust as per your requirement)
function sqf_edit_settings_page()
{
    if (isset($_GET['val_id'])) {
        $val_id = $_GET['val_id'];
        // You can implement the edit functionality as per your requirement
    }
}
