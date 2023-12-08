<?php
include('settings-fields-callback.php');

class SQF_SETTINGS_CLASS extends SQF_SETTINGS_CALLBACK
{
 
    public function __construct()
    {
        // Hook the settings functions to the appropriate action
        add_action('admin_menu', array($this, 'sqf_settings_menu'));

        $access_token = get_option('sqf_save_instagram_access_token');
        if ($access_token) {
            add_action('admin_menu',  'sqf_add_submenu_page_callback');
        }
        add_action('admin_init',  array($this, 'sqf_my_instagram_feed_settings'));

        add_shortcode('instagram-login',  'sqf_login_with_insta');
        add_shortcode('sqf_feed', 'sqf_display_feed');
    }

    function sqf_settings_menu()
    {
        add_menu_page(
            __('Social Quick Feed', 'social-quick-feed'),
            __('Social Quick Feed', 'social-quick-feed'),
            'manage_options',
            'sqf-settings',
            'sqf_settings_page'
        );
    }

    // Add section, settings and fields
    function sqf_my_instagram_feed_settings()
    {
        $view_type = get_option('sqf_my_instagram_feed_view_type', 'grid');

        // Add settings section for Instagram feed Settings
        add_settings_section(
            'sqf_my_instagram_feed_settings_section',
            __('Appearance', 'social-quick-feed'),
            array($this, 'sqf_my_instagram_feed_settings_section_callback'),
            'sqf_my_instagram_feed_settings'
        );

        // Add settings field for view type 
        add_settings_field(
            'sqf_my_instagram_feed_view_type',                            // ID of the field
            __('View Type', 'social-quick-feed'),                         // Title of the field
            array($this, 'sqf_my_instagram_feed_view_type_callback'),   // Function to display field markup
            'sqf_my_instagram_feed_settings',                          // Page where field should be displayed
            'sqf_my_instagram_feed_settings_section'                  // Section where field should be displayed
        );

        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',            // Option group
            'sqf_my_instagram_feed_view_type',              // Option name
            'sqf_my_instagram_feed_sanitize_view_type' //optional callback to sanitize
        );

        if ($view_type === 'grid') {
            // Add settings field for Grid Column 
            add_settings_field(
                'sqf_grid_columns',
                __('Grid Columns', 'social-quick-feed'),
                array($this, 'sqf_grid_columns_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_grid_columns',
                array(
                    'type' => 'integer', // Set the data type as needed
                    'default' => 2 // Set the default value here
                )
            );
        }

        if ($view_type === 'scrollable') {
            // Add settings field for height 
            add_settings_field(
                'sqf_scrollable_container_height',
                __('Container Height', 'social-quick-feed'),
                array($this, 'sqf_scrollable_container_height_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_scrollable_container_height',
            );

            // Add settings field for Width 
            add_settings_field(
                'sqf_scrollable_columns',
                __('Scrollable Columns', 'social-quick-feed'),
                array($this, 'sqf_scrollable_columns_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_scrollable_columns',
                array(
                    'type' => 'integer', // Set the data type as needed
                    'default' => 2 // Set the default value here
                )
            );
        }

        if ($view_type != 'masonry') {
            // Add settings field for height 
            add_settings_field(
                'sqf_my_instagram_feed_height',
                __('Height(px)', 'social-quick-feed'),
                array($this, 'sqf_my_instagram_feed_height_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_height',
            );

            // Add settings field for Width 
            add_settings_field(
                'sqf_my_instagram_feed_width',
                __('Width', 'social-quick-feed'),
                array($this, 'sqf_my_instagram_feed_width_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_width',
            );
        }

        if ($view_type === 'carousel') {
            // Add settings field for Carousel Columns
            add_settings_field(
                'sqf_grid_columns',
                __('Carousel Columns', 'social-quick-feed'),
                array($this, 'sqf_carousel_columns_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_carousel_columns',
                array(
                    'type' => 'integer', // Set the data type as needed
                    'default' => 2 // Set the default value here
                )
            );

            add_settings_field(
                'sqf_carousel_time_interval',
                __('Set Time Interval(Sec)', 'social-quick-feed'),
                array($this, 'sqf_carousel_time_interval_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_carousel_time_interval',
            );

            // Add settings field for Carousel View Type
            add_settings_field(
                'sqf_my_instagram_carousel_view_type',
                __('Carousel View Type', 'social-quick-feed'),
                array($this, 'sqf_my_instagram_carousel_view_type_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_carousel_view_type'
            );

            // Add settings field for Left Arrow Keys
            add_settings_field(
                'sqf_my_instagram_carousel_left_arrow',
                __('Carousel Left Arrow', 'social-quick-feed'),
                array($this, 'sqf_my_instagram_carousel_left_arrow_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_carousel_left_arrow',
            );

            function sqf_save_settings_left()
            {
                if (isset($_POST['sqf_carousel_left_arrow'])) {
                    $png_image = sanitize_text_field($_POST['sqf_carousel_left_arrow']);
                    update_option('sqf_carousel_left_arrow', $png_image);
                }
            }
            add_action('admin_init', 'sqf_save_settings_left');

            // Add settings field for Carousel Right Arrow
            add_settings_field(
                'sqf_my_instagram_carousel_right_arrow',
                __('Carousel Right Arrow', 'social-quick-feed'),
                array($this, 'sqf_my_instagram_carousel_right_arrow_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_carousel_right_arrow',
            );

            function sqf_save_settings_right()
            {
                if (isset($_POST['sqf_carousel_right_arrow'])) {
                    $png_image = sanitize_text_field($_POST['sqf_carousel_right_arrow']);
                    update_option('sqf_carousel_right_arrow', $png_image);
                }
            }
            add_action('admin_init', 'sqf_save_settings_right');

            //Instagram Color Shade Settings
            add_settings_field(
                'sqf_carousel_shade_field',
                __('Color Shade', 'social-quick-feed'),
                array($this, 'carousel_shade_field_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );

            // Register Settings
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_carousel_shade_field'
            );

            //Instagram Show Shade Color Settings
            add_settings_field(
                'sqf_my_plugin_color',
                __('Show Shade Color', 'social-quick-feed'),
                array($this, 'my_plugin_color_field_callback'),
                'sqf_my_instagram_feed_settings',
                'sqf_my_instagram_feed_settings_section'
            );
            register_setting(
                'sqf_my_instagram_feed_settings',
                'sqf_my_plugin_color'
            );
        }

        // Add settings field for Border Radius
        add_settings_field(
            'sqf_my_instagram_border_radius',
            __('Set Border Radius', 'social-quick-feed'),
            array($this, 'sqf_my_instagram_border_radius_callback'),
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_settings_section'
        );


        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_border_radius',
        );

        // Add settings field for Username
        add_settings_field(
            'sqf_my_instagram_username',
            __('Username', 'social-quick-feed'),
            array($this, 'sqf_my_instagram_username_callback'),
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_settings_section'
        );


        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_username',
        );

        // Post limit input
        add_settings_field(
            'sqf_post_limit_settings_field',
            __('Pictures Limit', 'social-quick-feed'),
            array($this, 'sqf_instagram_post_limit_callback'),
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_settings_section'
        );

        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',
            'sqf_instagram_post_limit',
            array(
                'type' => 'integer', // Set the data type as needed
                'default' => 6 // Set the default value here
            )
        );

        //Profile Link settings
        add_settings_field(
            'display_profile_id',
            __('Follow Button', 'social-quick-feed'),
            array($this, 'display_profile_checkbox_field_callback'),
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_settings_section'
        );

        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',
            'sqf_display_profile_checkbox',
        );

        //Profile Link text settings
        add_settings_field(
            'sqf_display_profile_text',
            __('Follow Button Text', 'social-quick-feed'),
            array($this, 'display_profile_text_field_callback'),
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_settings_section'
        );

        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',
            'sqf_display_profile_text',
            'Type your Button Name'
        );

        // Add settings field for width 
        add_settings_field(
            'sqf_my_instagram_feed_profile_place',
            __('Change Place of Follow Button', 'social-quick-feed'),
            array($this, 'sqf_my_instagram_feed_profile_place_callback'),
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_settings_section'
        );

        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_profile_place',
        );

        //Instagram icon field settings
        add_settings_field(
            'sqf_instagram_icon_field',
            __('Instagram Icon', 'social-quick-feed'),
            array($this, 'instagram_icon_field_callback'),
            'sqf_my_instagram_feed_settings',
            'sqf_my_instagram_feed_settings_section'
        );

        // Register settings
        register_setting(
            'sqf_my_instagram_feed_settings',
            'sqf_instagram_icon_field'
        );
    }
}
?>