<?php
class SQF_SETTINGS_CALLBACK
{
    // Settings section callback
    function sqf_my_instagram_feed_settings_section_callback()
    {
        echo esc_html__('Select the view type for your Instagram feed:', 'social-quick-feed');
    }
     
    // View type field callback
    function sqf_my_instagram_feed_view_type_callback()
    {
        $view_type = get_option('sqf_my_instagram_feed_view_type', 'grid');
?>
        <div class="sqf-radio-options">
            <div class="common grid-radio">
                <div class="common-img-label grid-img-label">
                    <div class="common-img grid-img">
                        <img src="<?php echo plugin_dir_url(__FILE__) ?>/assets/images/grid.svg" alt="grid">
                    </div>
                    <label for="sqf_my_instagram_feed_view_type">Grid</label>
                </div>
                <input type="radio" class="sqf-radio-grid <?php ($view_type == 'grid') ? 'selected' : ''; ?>" name="sqf_my_instagram_feed_view_type" value="grid" <?php checked('grid', $view_type, true); ?>>
            </div>
            <div class="common scrollable-radio">
                <div class="common-img-label scrollable-img-label">
                    <div class="common-img scrollable-img">
                        <img src="<?php echo plugin_dir_url(__FILE__) ?>/assets/images/scrollable.svg" alt="scrollable">
                    </div>
                    <label for="sqf_my_instagram_feed_view_type">Scrollable</label>
                </div>
                <input type="radio" class="sqf-radio-scrollable" name="sqf_my_instagram_feed_view_type" value="scrollable" <?php checked('scrollable', $view_type, true); ?>>
            </div>
            <div class="common carousel-radio">
                <div class="common-img-label carousel-img-label">
                    <div class="common-img carousel-img">
                        <img src="<?php echo plugin_dir_url(__FILE__) ?>/assets/images/carousel.svg" alt="carousel">
                    </div>
                    <label for="sqf_my_instagram_feed_view_type">Carousel</label>
                </div>
                <input type="radio" class="sqf-radio-carousel" name="sqf_my_instagram_feed_view_type" value="carousel" <?php checked('carousel', $view_type, true); ?>>
            </div>
            <div class="common masonry-radio">
                <div class="common-img-label masonry-img-label">
                    <div class="common-img masonry-img">
                        <img src="<?php echo plugin_dir_url(__FILE__) ?>/assets/images/masonry.svg" alt="masonry">
                    </div>
                    <label for="sqf_my_instagram_feed_view_type">Masonry</label>
                </div>
                <input type="radio" class="sqf-radio-masonry" name="sqf_my_instagram_feed_view_type" value="masonry" <?php checked('masonry', $view_type, true); ?>>
            </div>
        </div>
    <?php
    }

    // Sanitize view type setting
    function sqf_my_instagram_feed_sanitize_view_type($value)
    {
        $options = array(
            'grid',
            'scrollable',
            'carousel',
            'masonry'
        );
        if (!in_array($value, $options)) {
            $value = 'grid';
        }
        return $value;
    }
    function sqf_my_instagram_username_callback()
    {
    ?>
        <input id="sqf-username" type="checkbox" name="sqf_my_instagram_username" value="1" <?php checked(1, esc_attr__(get_option('sqf_my_instagram_username', 'social-quick-feed'), true)); ?> />
    <?php
    }

        //field to check for showing follow button
        function display_profile_checkbox_field_callback()
        {
        ?>
            <input type="checkbox" name="sqf_display_profile_checkbox" value="1" <?php checked(1, get_option('sqf_display_profile_checkbox'), true); ?> />
        <?php
        }
    
        //field to change the button name
        function display_profile_text_field_callback()
        {
        ?>
            <input name="sqf_display_profile_text" type="text" id="sqf-follow-button" value="<?php echo esc_attr(get_option('sqf_display_profile_text', 'Follow Button')) ?>">
        <?php
        }

            //field to enter post limit
    function sqf_instagram_post_limit_callback()
    {
        $post_limit = get_option('sqf_instagram_post_limit', 6);
    ?>
        <input type="number" name="sqf_instagram_post_limit" id="instagram_post_limit" value="<?php echo esc_attr($post_limit); ?>">
    <?php
    }


    function sqf_grid_columns_callback()
    {
        $sqf_grid_columns = get_option('sqf_grid_columns', '2');
    ?>
        <select id="sqf-grid-columns" name="sqf_grid_columns">
            <option value="2" <?php selected('2', $sqf_grid_columns); ?>>Two</option>
            <option value="3" <?php selected('3', $sqf_grid_columns); ?>>Three</option>
            <option value="4" <?php selected('4', $sqf_grid_columns); ?>>Four</option>
            <option value="5" <?php selected('5', $sqf_grid_columns); ?>>Five</option>
            <option value="6" <?php selected('6', $sqf_grid_columns); ?>>Six</option>
        </select>
    <?php
    }

    function sqf_scrollable_container_height_callback()
    {
        $scrollable_container_height = get_option('sqf_scrollable_container_height');
    ?>
        <input placeholder="Height" type="number" id="sqf-scrollable-height" name="sqf_scrollable_container_height" value="<?php echo esc_attr__($scrollable_container_height, 'social-quick-feed'); ?>">
    <?php
    }

    function sqf_scrollable_columns_callback()
    {
    ?>
        <select id="sqf-scrollable-columns" name="sqf_scrollable_columns">
            <option value="1" <?php selected('1', get_option('sqf_scrollable_columns')); ?>>One</option>
            <option value="2" <?php selected('2', get_option('sqf_scrollable_columns')); ?>>Two</option>
            <option value="3" <?php selected('3', get_option('sqf_scrollable_columns')); ?>>Three</option>
            <option value="4" <?php selected('4', get_option('sqf_scrollable_columns')); ?>>Four</option>
        </select>
    <?php
    }


    function sqf_my_instagram_feed_height_callback()
    {
    ?>
        <input placeholder="Height" type="number" id="my-plugin-height" name="sqf_my_instagram_feed_height" value="<?php echo esc_attr__(get_option('sqf_my_instagram_feed_height'), 'social-quick-feed'); ?>">
    <?php
    }

    function sqf_my_instagram_feed_width_callback()
    {
    ?>
        <select id="my-plugin-width" name="sqf_my_instagram_feed_width">
            <option value="full-width" <?php selected('full-width', get_option('sqf_my_instagram_feed_width')); ?>>Full Width</option>
            <option value="container-width" <?php selected('container-width', get_option('sqf_my_instagram_feed_width')); ?>>Container</option>
        </select>
    <?php
    }

    function sqf_carousel_columns_callback()
    {
    ?>
        <select id="sqf-carousel-columns" name="sqf_carousel_columns">
            <option value="1" <?php selected('1', get_option('sqf_carousel_columns')); ?>>One</option>
            <option value="2" <?php selected('2', get_option('sqf_carousel_columns')); ?>>Two</option>
            <option value="3" <?php selected('3', get_option('sqf_carousel_columns')); ?>>Three</option>
            <option value="4" <?php selected('4', get_option('sqf_carousel_columns')); ?>>Four</option>
        </select>
    <?php
    }

    function sqf_carousel_time_interval_callback()
    {
        $time_interval = get_option('sqf_carousel_time_interval', 2);
    ?>
        <input placeholder="Time interval in Sec" type="number" id="sqf-carousel-time-interval" name="sqf_carousel_time_interval" value="<?php echo esc_attr__($time_interval, 'social-quick-feed'); ?>">
    <?php
    }

    //carousel type function
    function sqf_my_instagram_carousel_view_type_callback()
    {
        $options = get_option('sqf_carousel_view_type', 'autoplay');
    ?>
        <label>
            <input id="autoplay" onchange="carouselAction()" type="radio" name="sqf_carousel_view_type" value="autoplay" <?php checked($options, 'autoplay'); ?>>
            Autoplay
        </label>
        <br>
        <label>
            <input id="button_click" onchange="carouselAction()" type="radio" name="sqf_carousel_view_type" value="button_click" <?php checked($options, 'button_click'); ?>>
            Button Click
        </label>
        <p id="result"></p>
    <?php
    }   

    //carousel arrow key function
    function sqf_my_instagram_carousel_left_arrow_callback()
    {
        $custom_png = get_option('sqf_carousel_left_arrow');
        $left_default_png = plugin_dir_url(__FILE__) . 'assets/images/arrow-forward-circle.png';

        // Add the upload button
        echo '<input type="button" class="button button-secondary" value="Upload PNG" id="sqf-upload-png-left" />';
        // Add the hidden input field to store the uploaded PNG image URL
        echo '<input type="hidden" id="sqf-custom-png-left" name="sqf_carousel_left_arrow" value="' . esc_html__($custom_png) . '" />';

        if (!empty($custom_png)) {
            echo '<img src="' . esc_attr__($custom_png, 'social-quick-feed') . '" alt="Custom Left PNG" class = "custom-png" style="max-width: 100px;" />';
        } else {
            echo '<img src="' . esc_attr__($left_default_png, 'social-quick-feed') . '" alt="Custom Left PNG" class = "custom-png" style="max-width: 100px;" />';
        }
    }

    function sqf_my_instagram_carousel_right_arrow_callback()
    {
        $custom_png = get_option('sqf_carousel_right_arrow');
        $right_default_png = plugin_dir_url(__FILE__) . 'assets/images/arrow-forward-circle.png';

        // Add the upload button
        echo '<input type="button" class="button button-secondary" value="Upload PNG" id="sqf-upload-png-right" />';
        // Add the hidden input field to store the uploaded PNG image URL
        echo '<input type="hidden" id="sqf-custom-png-right" name="sqf_carousel_right_arrow" value="' . esc_attr($custom_png) . '" />';

        if (!empty($custom_png)) {
            echo '<img src="' . esc_url($custom_png) . '" alt="Custom Right PNG" class = "custom-png" style="max-width: 100px;"/>';
        } else {
            echo '<img src="' . esc_url($right_default_png) . '" alt="Custom Right PNG" class = "custom-png" style="max-width: 100px;"/>';
        }
    }

    function sqf_my_instagram_border_radius_callback()
    {
    ?>
        <input placeholder="Border Radius" type="number" id="sqf-border-radius" name="sqf_my_instagram_border_radius" value="<?php echo esc_attr(get_option('sqf_my_instagram_border_radius')); ?>">
    <?php
    }

    //carousel shade function
    function carousel_shade_field_callback()
    {
    ?>
        <input type="checkbox" name="sqf_carousel_shade_field" value="1" <?php checked(1, get_option('sqf_carousel_shade_field'), true); ?> />
    <?php
    }

    //carousel shade color picker function
    function my_plugin_color_field_callback()
    {
        $value = get_option('sqf_my_plugin_color', '#ffffff');
        echo '<input type="color" id="my-plugin-color" name="sqf_my_plugin_color" value="' . esc_attr($value) . '" class="my-color-field">';
    }




    function sqf_my_instagram_feed_profile_place_callback()
    {
    ?>
        <select id="profile-place-select" name="sqf_my_instagram_feed_profile_place">
            <option value="top" <?php selected('top', get_option('sqf_my_instagram_feed_profile_place')); ?>>Top of the Feed</option>
            <option value="bottom" <?php selected('bottom', get_option('sqf_my_instagram_feed_profile_place')); ?>>Bottom of the Feed</option>
        </select>
    <?php
    }

    //instagram icon function
    function instagram_icon_field_callback()
    {
    ?>
        <input id="shade_inputId" type="checkbox" name="sqf_instagram_icon_field" value="1" <?php checked(1, get_option('sqf_instagram_icon_field'), true); ?> />
<?php
    }
}
?>