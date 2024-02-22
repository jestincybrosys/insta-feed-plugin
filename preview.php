<?php
// display feeds on webpage
function sqf_display_feed()
{
    $feed = sqf_get_instagram_feeds();
 
    if ($feed) {
        $username = $feed[0]->username;
        $username_link = 'https://www.instagram.com/' . $username;
        $access_token_with_id = get_option('sqf_save_instagram_access_token');
        $view_type = get_option('sqf_my_instagram_feed_view_type', 'grid');
        $sqf_username = get_option('sqf_my_instagram_username');
        $post_limit = get_option('sqf_instagram_post_limit');
        $view_profile = get_option('sqf_display_profile_checkbox');
        $profile_button_place = get_option('sqf_my_instagram_feed_profile_place');
        $top_class = ($profile_button_place == 'top') ? 'profile-top' : null;
        $width = get_option('sqf_my_instagram_feed_width');
        $border_radius = get_option('sqf_my_instagram_border_radius','0');
        $insta_icon = get_option('sqf_instagram_icon_field');
        $follow_btn_text = get_option('sqf_display_profile_text');

        //grid
        $grid_width = $width == 'container-width' ? 'container-width' : null;
        $grid_height = get_option('sqf_my_instagram_feed_height');
        $grid_columns = get_option('sqf_grid_columns');

        //scrollable
        $scrollable_height = get_option('sqf_my_instagram_feed_height');
        $scrollable_container_height = get_option('sqf_scrollable_container_height');
        $scrollable_columns = get_option('sqf_scrollable_columns');

        //carousel
        $carousel_columns = get_option('sqf_carousel_columns');
        $time_interval = get_option('sqf_carousel_time_interval');
        $carousel_auto = (get_option('sqf_carousel_view_type') == 'autoplay') ? 'carousel-autoplay' : 'carousel-button-click';
        $carousel_height = get_option('sqf_my_instagram_feed_height');
        $shade_color = get_option('sqf_my_plugin_color	');
        $left_shade_style = get_option('sqf_carousel_shade_field') == 1 ? 'background-image: linear-gradient(to left, #37000000,' . $shade_color . ' );' : '';
        $right_shade_style = get_option('sqf_carousel_shade_field') == 1 ? 'background-image: linear-gradient(to right,#37000000,' . $shade_color . ');' : '';
        $left_arrow = get_option('sqf_carousel_left_arrow');
        $right_arrow = get_option('sqf_carousel_right_arrow');

        $left_default_png = plugin_dir_url(__FILE__) . 'assets/images/arrow-back-circle.png';
        $right_default_png = plugin_dir_url(__FILE__) . 'assets/images/arrow-forward-circle.png';
?>
        <div class="preview-box ">
                        <?php
                if (is_admin() && $access_token_with_id) {
                    $current_page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

                    // Check if the current page is your plugin's settings page
                    if ($current_page === 'sqf-sub-settings') {
                ?>
                        <div class="badge-save-message">
                            <h3 class="preview-title badge" style="background-color: #2271B1; font-weight: 400">Preview</h3>
                            <div id="saveMessage" style="display: none;"></div>
                        </div>
                <?php
                    }
        

            if ($view_type === 'grid') {
                $output = '<div class="grid-img-container ' . $grid_width . '">
                              <div class="username-follow px-2">
                                ' . ($sqf_username ? '<div class="username-above-feed"><a href="' . esc_url($username_link) . '">' . $username . '</a></div>' : '') . '
                                ' . (($view_profile == 1 && $profile_button_place == 'top') ? '<div class="account-follow ' . $top_class . '"><a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a></div>' : '') . '
                              </div>
                              <div class="row">';
                $i = 0;
                for ($col = 2; $col <= 6; $col++) {
                    if ($grid_columns == $col) {
                        foreach ($feed as $post) {
                            $i++;
                            if ($i > $post_limit) break;
                            $output .= '<div class="col-lg-' . (12 / $col) . ' col-md-12 mb-4 mb-lg-0 sqf-post-grid p-1" style="height: ' . (empty($grid_height) ? '150' : esc_attr__($grid_height)) . 'px;">
                                          <a href="' . esc_url($post->permalink) . '" target="_blank">
                                            ' . ($post->media_type == 'VIDEO' ? '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>' : '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;"/>') . '
                                            ' . ($insta_icon == 1 ? '<span class="dashicons dashicons-instagram"></span>' : '') . '
                                          </a>
                                        </div>';
                        }
                        break;
                    }
                }
                $output .= '</div>';
                $output .= ($view_profile == 1 && $profile_button_place == 'bottom') ? '<div class="account-follow"><a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a></div>' : '';
                $output .= '</div>';
                return $output;
            }
            
            
            elseif ($view_type === 'scrollable') {
                $output = '<div class="username-follow p-2">' .
                              ($sqf_username ? '<div class="username-above-feed"><a href="' . esc_url($username_link) . '">' . $username . '</a></div>' : '') .
                              (($view_profile == 1 && $profile_button_place == 'top') ? '<div class="account-follow ' . $top_class . '"><a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a></div>' : '') .
                          '</div>
                          <div class="scroll-img-container" style="height: ' . (empty($scrollable_container_height) ? '150' : esc_attr__($scrollable_container_height)) . 'px;">
                              <div class="row">';
                $i = 0;
                for ($col = 1; $col <= $scrollable_columns; $col++) {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i > $post_limit) break;
                        $output .= '<div class="col-lg-' . (12 / $scrollable_columns) . '">
                                      <div class="sqf-post-scrollable" style="height: ' . (empty($scrollable_height) ? '150' : esc_attr__($scrollable_height)) . 'px;">
                                          <a href="' . esc_url($post->permalink) . '" target="_blank">
                                              ' . ($post->media_type == 'VIDEO' ? '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>' : '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;" />') . '
                                              ' . ($insta_icon == 1 ? '<span class="dashicons dashicons-instagram"></span>' : '') . '
                                          </a>
                                      </div>
                                  </div>';
                    }
                    if ($i > $post_limit) break;
                }
                $output .= '</div>
                          </div>';
                $output .= ($view_profile == 1 && $profile_button_place == 'bottom') ? '<div class="account-follow"><a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a></div>' : '';
                return $output;
            }
            
            
            elseif ($view_type === 'carousel') {
                $output = '<div class="username-follow p-2" id="sqf-carousel-col" data-timeinterval="' . esc_attr__($time_interval * 1000) . '" data-colattribute="' . esc_attr__($carousel_columns) . '">';
                $output .= ($sqf_username ? '<div class="username-above-feed"><a href="' . esc_url($username_link) . '">' . $username . '</a></div>' : '');
                $output .= (($view_profile == 1 && $profile_button_place == 'top') ? '<div class="account-follow ' . $top_class . '"><a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a></div>' : '') . '</div>';
            
                $output .= '<div class="carousel-img-container carousel-' . esc_attr__($carousel_columns) . '" style="height: ' . (empty($carousel_height) ? '150' : esc_attr__($carousel_height)) . 'px;" id="shadeId">';
                $output .= '<div class="carousel-row">';
                $i = 0;
                $j = 0;
            
                foreach ($feed as $post) {
                    $i++;
                    if ($i > $post_limit) break;
            
                    $output .= '<div class="sqf-post-carousel ' . $carousel_auto . '" style="width: ' . esc_attr__(100 / $carousel_columns) . '%;" data-target="' . esc_attr__($j++) . '">';
                    $output .= '<a href="' . esc_url($post->permalink) . '" target="_blank">';
                    $output .= ($post->media_type == 'VIDEO') ? '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>' : '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;" />';
                    $output .= ($insta_icon == 1) ? '<span class="dashicons dashicons-instagram"></span>' : '';
                    $output .= '</a></div>';
                }
            
                $output .= '</div><div class="nav">';
                $output .= '<button class="prev" style="' . esc_attr__($left_shade_style) . '"><img src="' . (!empty($left_arrow) ? esc_attr__($left_arrow, 'social-quick-feed') : esc_attr__($left_default_png, 'social-quick-feed')) . '" alt="Custom Left PNG" /></button>';
                $output .= '<button class="next" style="' . esc_attr__($right_shade_style) . '"><img src="' . (!empty($right_arrow) ? esc_attr__($right_arrow, 'social-quick-feed') : esc_attr__($right_default_png, 'social-quick-feed')) . '" alt="Custom Right PNG" /></button>';
                $output .= '</div></div>';
            
                $output .= ($view_profile == 1 && $profile_button_place == 'bottom') ? '<div class="account-follow"><a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a></div>' : '';
                return $output;
            }
            
            
            elseif ($view_type === 'masonry') {
                $output = '';
                // username above feed
                $output .= '<div class = "username-follow p-2">';
                if ($sqf_username) {
                    $output .= '<div class="username-above-feed">
                                <a href="' . esc_url($username_link) . '">' . $username . '</a>
                    </div>';
                }
                if ($view_profile == 1 && $profile_button_place == 'top') {
                    $output .= '<div class="account-follow' . ' ' . $top_class . '">
                            <a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a>
                        </div>';
                }
                $output .= '</div>';
                $output .= '<div class="masonry-img-container">';
                $output .=  '<div class="row">';
                $i = 0;
                foreach ($feed as $post) {
                    $i++;
                    if ($i == $post_limit + 1) break;
                    $output .= '<div class="col-md-6 sqf-post-masonry">';
                    $output .= '<a href="' . esc_url($post->permalink) . '" target="_blank">';
                    if (($post->media_type == 'VIDEO')) {
                        $output .= '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>';
                    } else {
                        $output .= '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;" />';
                    }
                    if ($insta_icon == 1) {
                        $output .= '<span class="dashicons dashicons-instagram"></span>';
                    }
                    $output .= '</a>';
                    $output .= '</div>';
                }
                $output .=  '</div>';
                $output .= '</div>';
                if ($view_profile == 1 && $profile_button_place == 'bottom') {
                    $output .= '<div class="account-follow">
                            <a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a>
                        </div>';
                }
                $output .= '</div>';
                return $output;
            }
        }
    }
}
    ?>