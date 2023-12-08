<?php
function sqf_my_admin_theme_style()
{
    wp_enqueue_style('my-admin-theme', plugins_url('assets/css/admin/wp-admin.css', __FILE__));
}

function sqf_add_style()
{
    wp_register_style('sqf_stylesheet', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_style('sqf_stylesheet');
}

 
function sqf_custom_javascript()
{
    wp_register_script('sqf_script', plugin_dir_url(__FILE__) . 'assets/js/script.js', null, null, true);
    wp_enqueue_script('sqf_script');
}


function sqf_my_scripts()
{
    wp_enqueue_style('bootstrap4', plugin_dir_url(__FILE__) . '/assets/bootstrap/css/bootstrap.min.css');
    wp_enqueue_script('boot3', plugin_dir_url(__FILE__) . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '', true);
}
?>