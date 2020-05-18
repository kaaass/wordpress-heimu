<?php
/*
Plugin Name: Heimu
Plugin URI: https://blog.kaaass.net/archives/1372
Description: Add heimu and its short code for your passage.
Version: 1.0.0
Author: KAAAsS
Author URI: https://kaaass.net
License: MIT License
*/

define('HEIMU_ASSETS_VERSION', '1.0.0');
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
    wp_register_style('heimu', plugins_url('heimu/heimu.css', dirname(__FILE__)),
        false, HEIMU_ASSETS_VERSION);
}

add_action('init', 'heimu_init');

/*
 * Short code
 */

function heimu_shortcode_handler($atts, $content = null)
{
    global $heimu_options;

    wp_enqueue_style('heimu');

    return '<span class="heimu" title="' . $heimu_options['heimu_float_tips'] . '">' . do_shortcode($content) . '</span>';
}

add_shortcode($heimu_options['heimu_shortcode'], 'heimu_shortcode_handler');

if (is_admin()) {
    require 'admin_config.php';
}