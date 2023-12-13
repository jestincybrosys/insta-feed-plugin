<?php
/*
 * Plugin Name: Social Quick Feed
 * Plugin URI:        https://wordpress.org/plugins/social-quick-feed
 * Description:       "Social Quick Feed" plugin allows you to easily display custom Instagram feed, Instagram photos and videos from Instagram timeline. You can use the shortcode from main page to display the feed on webpage. Its completely customizable with lots of optional settings.
 * Version:           1.0.0
 * Author:            Cybrosys Technologies
 * Author URI: https://www.cybrosys.com
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 */
 
include('enqueue-styles.php');
include('login.php');
include('main-page.php');
include('get-feeds.php');
include('settings-fields.php');
// include('settings_fields.php');
include('appearance.php');
include('preview.php');
include('shortcode.php');

$settings_fields = new SQF_SETTINGS_CLASS();
?>