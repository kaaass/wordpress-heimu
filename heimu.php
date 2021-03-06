<?php
/*
Plugin Name: Heimu
Plugin URI: https://blog.kaaass.net/archives/1372
Description: Add heimu and its short code for your passage.
Version: 1.1.0-hotfix
Author: KAAAsS
Author URI: https://kaaass.net
License: MIT License
*/

define('HEIMU_ASSETS_VERSION', '1.1.0');
define('HEIMU_DEVELOPMENT', true);
define('HEIMU_BASE_NAME', plugin_basename(__FILE__));

$default_options = array(
    'heimu_shortcode' => 'hm',
    'heimu_float_tips' => __('你知道的太多了', 'Heimu')
);
$heimu_options = wp_parse_args(get_option('heimu_settings'), $default_options);

/*
 * Load assets
 */
function heimu_init()
{
    wp_register_style(
        'heimu',
        plugins_url('heimu/heimu.css', dirname(__FILE__)),
        false,
        HEIMU_ASSETS_VERSION
    );
}

add_action('init', 'heimu_init');

/*
 * Short code
 */
function heimu_shortcode_wrapper()
{
    global $heimu_options;

    if (isset($heimu_options['blur']) and $heimu_options['blur'] == '1') {
        $class = 'heimu-blur';
    } else {
        $class = 'heimu';
    }

    if (empty($heimu_options['heimu_float_tips'])) {
        $title = '';
    } else {
        $title = ' title="' . $heimu_options['heimu_float_tips'] . '"';
    }

    return [
        '<span class="' . $class . '"' . $title . '>',
        '</span>'
    ];
}

$heimu_wrapper = heimu_shortcode_wrapper();

function heimu_shortcode_handler($atts, $content = null)
{
    wp_enqueue_style('heimu');

    global $heimu_wrapper;

    return $heimu_wrapper[0] . do_shortcode($content) . $heimu_wrapper[1];
}

function heimu_shortcode_register()
{
    global $heimu_options;
    add_shortcode($heimu_options['heimu_shortcode'], 'heimu_shortcode_handler');
}

function heimu_comment_shortcode_handler($content)
{
    global $shortcode_tags;
    $old_shortcode = $shortcode_tags;
    // Only process heimu tag to ensure security
    remove_all_shortcodes();
    heimu_shortcode_register();
    $result = do_shortcode($content);
    // Recover
    $shortcode_tags = $old_shortcode;
    return $result;
}

heimu_shortcode_register();

// Heimu shortcode in comment
if (isset($heimu_options['comment_shortcode']) and $heimu_options['comment_shortcode'] == '1') {
    add_filter('comment_text', 'heimu_comment_shortcode_handler');
}

// Load gutenberg support
if (!(isset($heimu_options['disable_guten']) and $heimu_options['disable_guten'] == '1')) {
    require 'blockeditor/main.php';
}

// Load admin page
if (is_admin()) {
    require 'admin_config.php';
}