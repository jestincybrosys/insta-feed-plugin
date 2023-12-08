<?php
// display feeds on webpage
function sqf_display_feed()
{
    $feed = sqf_get_instagram_feed();
 
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
        $border_radius = get_option('sqf_my_instagram_border_radius');
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
        <div class="preview-box">
            <?php
            if (is_admin() && $access_token_with_id) {
            ?>
                <div class="badge-save-message">
                    <h3 class="preview-title badge" style="background-color: #2271B1;font-weight:400">Preview</h3>
                    <div id="saveMessage" style="display: none;"></div>
                </div>
    <?php
            }
            if ($view_type === 'grid' && $access_token_with_id) {
                $output = '';
                $output .= '<div class="grid-img-container' . ' ' . $grid_width . '">';
                $output .= '<div class = "username-follow px-2">';
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
                $output .=  '<div class="row">';
                $i = 0;
                if ($grid_columns == 2) {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="col-lg-6 col-md-12 mb-4 mb-lg-0 sqf-post-grid p-1" style="height: ' . (empty($grid_height) ? '150' : esc_attr__($grid_height)) . 'px;">';
                        $output .= '<a href="' . esc_url($post->permalink) . '" target="_blank">';
                        if (($post->media_type == 'VIDEO')) {
                            $output .= '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>';
                        } else {
                            $output .= '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;"/>';
                        }
                        if ($insta_icon == 1) {
                            $output .= '<span class="dashicons dashicons-instagram"></span>';
                        }
                        $output .= '</a>';
                        $output .= '</div>';
                    }
                } elseif ($grid_columns == 3) {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="col-lg-4 col-md-12 mb-4 mb-lg-0 sqf-post-grid p-1" style="height: ' . (empty($grid_height) ? '150' : esc_attr__($grid_height)) . 'px;">';
                        $output .= '<a href="' . esc_url($post->permalink) . '" target="_blank">';
                        if (($post->media_type == 'VIDEO')) {
                            $output .= '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>';
                        } else {
                            $output .= '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;"/>';
                        }
                        if ($insta_icon == 1) {
                            $output .= '<span class="dashicons dashicons-instagram"></span>';
                        }
                        $output .= '</a>';
                        $output .= '</div>';
                    }
                } elseif ($grid_columns == 4) {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="col-lg-3 col-md-12 mb-4 mb-lg-0 sqf-post-grid p-1" style="height: ' . (empty($grid_height) ? '150' : esc_attr__($grid_height)) . 'px;">';
                        $output .= '<a href="' . esc_url($post->permalink) . '" target="_blank">';
                        if (($post->media_type == 'VIDEO')) {
                            $output .= '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>';
                        } else {
                            $output .= '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;"/>';
                        }
                        if ($insta_icon == 1) {
                            $output .= '<span class="dashicons dashicons-instagram"></span>';
                        }
                        $output .= '</a>';
                        $output .= '</div>';
                    }
                } elseif ($grid_columns == 5) {
                    $output .= '<div class = "grid-container">';
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="grid-item mb-4 mb-lg-0 sqf-post-grid p-1" style="height: ' . (empty($grid_height) ? '150' : esc_attr__($grid_height)) . 'px;">';
                        $output .= '<a href="' . esc_url($post->permalink) . '" target="_blank">';
                        if (($post->media_type == 'VIDEO')) {
                            $output .= '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>';
                        } else {
                            $output .= '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '"class="img-fluid" style="border-radius:'  . esc_attr__($border_radius) . 'px;"/>';
                        }
                        if ($insta_icon == 1) {
                            $output .= '<span class="dashicons dashicons-instagram"></span>';
                        }
                        $output .= '</a>';
                        $output .= '</div>';
                    }
                    $output .= '</div>';
                } elseif ($grid_columns == 6) {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="col-lg-2 col-md-12 mb-4 mb-lg-0 sqf-post-grid p-1" style="height: ' . (empty($grid_height) ? '150' : esc_attr__($grid_height)) . 'px;">';
                        $output .= '<a href="' . esc_url($post->permalink) . '" target="_blank">';
                        if (($post->media_type == 'VIDEO')) {
                            $output .= '<video src="' . esc_attr__($post->media_url) . '" controls style="border-radius:' . esc_attr__($border_radius) . 'px;"></video>';
                        } else {
                            $output .= '<img src="' . esc_attr__($post->media_url) . '" alt="' . $post->caption . '" style="border-radius:' . esc_attr__($border_radius) . 'px;"/>';
                        }
                        if ($insta_icon == 1) {
                            $output .= '<span class="dashicons dashicons-instagram"></span>';
                        }
                        $output .= '</a>';
                        $output .= '</div>';
                    }
                } else {
                }
                if ($view_profile == 1 && $profile_button_place == 'bottom') {
                    $output .= '<div class="account-follow">
                                    <a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a>
                                </div>';
                }
                $output .= '</div>';
                $output .= '</div>';
                return $output;
            } elseif ($view_type === 'scrollable') {
                $output = '';
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
                $output .= '<div class="scroll-img-container" style= "height:' . (empty($scrollable_container_height) ? '150' : esc_attr__($scrollable_container_height)) . 'px;">';
                $output .=  '<div class="row">';
                $i = 0;
                if ($scrollable_columns == '1') {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .=  '<div class="col-lg-12">';
                        $output .= '<div class="sqf-post-scrollable" style="height: ' . (empty($scrollable_height) ? '150' : esc_attr__($scrollable_height)) . 'px;">';
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
                        $output .= '</div>';
                    }
                } elseif ($scrollable_columns == '2') {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .=  '<div class="col-lg-6">';
                        $output .= '<div class="sqf-post-scrollable" style="height: ' . (empty($scrollable_height) ? '150' : esc_attr__($scrollable_height)) . 'px;">';
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
                        $output .= '</div>';
                    }
                } elseif ($scrollable_columns == '3') {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .=  '<div class="col-lg-4">';
                        $output .= '<div class="sqf-post-scrollable" style="height: ' . (empty($scrollable_height) ? '150' : esc_attr__($scrollable_height)) . 'px;">';
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
                        $output .= '</div>';
                    }
                } elseif ($scrollable_columns == '4') {
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .=  '<div class="col-lg-3">';
                        $output .= '<div class="sqf-post-scrollable" style="height: ' . (empty($scrollable_height) ? '150' : esc_attr__($scrollable_height)) . 'px;">';
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
                        $output .= '</div>';
                    }
                }
                $output .=  '</div>';
                $output .=  '</div>';
                $output .= '</div>';
                if ($view_profile == 1 && $profile_button_place == 'bottom') {
                    $output .= '<div class="account-follow">
                                    <a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a>
                                </div>';
                }
                return $output;
            } elseif ($view_type === 'carousel') {
                $output = '';
                // username above feed
                $output .= '<div class = "username-follow p-2" id = "sqf-carousel-col" data-timeinterval="' . __($time_interval * 1000) . '" data-colattribute =' . __($carousel_columns) . '>';
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
                if ($carousel_columns == '1') {
                    $output .= '<div class="carousel-img-container carousel-one' . '" style = "height: ' . (empty($carousel_height) ? '150' : esc_attr__($carousel_height)) . 'px;" id="shadeId">';
                    $output .=  '<div class="carousel-row">';
                    $i = 0;
                    $j = 0;

                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="sqf-post-carousel' . ' ' . $carousel_auto . '" style = "width:100%;" data-target=' . $j++ . '>';
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
                    $output .=  '<div class="nav">';
                    $output .=  '<button  class="prev" style="' . esc_attr__($left_shade_style) . '">
                                    <img src="' . (!empty($left_arrow) ? esc_attr__($left_arrow, 'social-quick-feed') : esc_attr__($left_default_png, 'social-quick-feed')) . '" alt="Custom Left PNG" />
                                </button>';
                    $output .=  '<button  class="next" style="' . esc_attr__($right_shade_style) . '">
                                    <img src="' . (!empty($right_arrow) ? esc_attr__($right_arrow, 'social-quick-feed') : esc_attr__($right_default_png, 'social-quick-feed')) . '" alt="Custom Right PNG" />
                                </button>';
                    $output .=  '</div>';
                    $output .= '</div>';
                } elseif ($carousel_columns == '2') {
                    $output .= '<div class="carousel-img-container carousel-two' . '" style = "height: ' . (empty($carousel_height) ? '150' : esc_attr__($carousel_height)) . 'px;" id="shadeId">';
                    $output .=  '<div class="carousel-row">';
                    $i = 0;
                    $j = 0;

                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="sqf-post-carousel' . ' ' . $carousel_auto . '" style = "width:50%;" data-target=' . $j++ . '>';
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
                    $output .=  '<div class="nav">';
                    $output .=  '<button  class="prev" style="' . esc_attr__($left_shade_style) . '">
                                    <img src="' . (!empty($left_arrow) ? esc_attr__($left_arrow, 'social-quick-feed') : esc_attr__($left_default_png, 'social-quick-feed')) . '" alt="Custom Left PNG" />
                                </button>';
                    $output .=  '<button  class="next" style="' . esc_attr__($right_shade_style) . '">
                                    <img src="' . (!empty($right_arrow) ? esc_attr__($right_arrow, 'social-quick-feed') : esc_attr__($right_default_png, 'social-quick-feed')) . '" alt="Custom Right PNG" />
                                </button>';
                    $output .=  '</div>';
                    $output .= '</div>';
                } elseif ($carousel_columns == '3') {
                    $output .= '<div class="carousel-img-container carousel-three' . '" style = "height: ' . (empty($carousel_height) ? '150' : esc_attr__($carousel_height)) . 'px;" id="shadeId">';
                    $output .=  '<div class="carousel-row">';
                    $i = 0;
                    $j = 0;
                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="sqf-post-carousel' . ' ' . $carousel_auto . '" data-target=' . $j++ . '>';
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
                    $output .=  '<div class="nav">';
                    $output .=  '<button  class="prev" style="' . esc_attr__($left_shade_style) . '">
                                    <img src="' . (!empty($left_arrow) ? esc_attr__($left_arrow, 'social-quick-feed') : esc_attr__($left_default_png, 'social-quick-feed')) . '" alt="Custom Left PNG" />
                                </button>';
                    $output .=  '<button  class="next" style="' . esc_attr__($right_shade_style) . '">
                                    <img src="' . (!empty($right_arrow) ? esc_attr__($right_arrow, 'social-quick-feed') : esc_attr__($right_default_png, 'social-quick-feed')) . '" alt="Custom Right PNG" />
                                </button>';
                    $output .=  '</div>';
                    $output .= '</div>';
                } elseif ($carousel_columns == '4') {
                    $output .= '<div class="carousel-img-container carousel-four' . '" style = "height: ' . (empty($carousel_height) ? '150' : esc_attr__($carousel_height)) . 'px;" id="shadeId">';
                    $output .=  '<div class="carousel-row">';
                    $i = 0;
                    $j = 0;

                    foreach ($feed as $post) {
                        $i++;
                        if ($i == $post_limit + 1) break;
                        $output .= '<div class="sqf-post-carousel' . ' ' . $carousel_auto . '" style = "width:23%;" data-target=' . $j++ . '>';
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
                    $output .=  '<div class="nav">';
                    $output .=  '<button  class="prev" style="' . esc_attr__($left_shade_style) . '">
                                    <img src="' . (!empty($left_arrow) ? esc_attr__($left_arrow, 'social-quick-feed') : esc_attr__($left_default_png, 'social-quick-feed')) . '" alt="Custom Left PNG" />
                                </button>';
                    $output .=  '<button  class="next" style="' . esc_attr__($right_shade_style) . '">
                                    <img src="' . (!empty($right_arrow) ? esc_attr__($right_arrow, 'social-quick-feed') : esc_attr__($right_default_png, 'social-quick-feed')) . '" alt="Custom Right PNG" />
                                </button>';
                    $output .=  '</div>';
                    $output .= '</div>';
                }

                if ($view_profile == 1 && $profile_button_place == 'bottom') {
                    $output .= '<div class="account-follow">
                                    <a href="' . esc_url($username_link) . '" class="follow-btn">' . $follow_btn_text . '</a>
                                </div>';
                }
                return $output;
            } elseif ($view_type === 'masonry') {
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
    ?>