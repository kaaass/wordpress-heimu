<?php
/*
 * Gutenberg Support
 */

function heimu_guten_enqueue()
{
    if (HEIMU_DEVELOPMENT) {
        $base = 'build';
    } else {
        $base = '';
    }

    $asset_file = include(plugin_dir_path(__FILE__) . "$base/index.asset.php");

    wp_register_script(
        'heimu_guten',
        plugins_url("$base/index.js", __FILE__),
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_register_style(
        'heimu_guten',
        plugins_url('css/heimu-editor.css', __FILE__),
        false,
        HEIMU_ASSETS_VERSION
    );

    wp_enqueue_script('heimu_guten');
    wp_enqueue_style('heimu_guten');
}

add_action('enqueue_block_editor_assets', 'heimu_guten_enqueue');

function heimu_guten_tag($content)
{
    wp_enqueue_style('heimu');
    global $heimu_wrapper;
    $content = str_replace([
        '<heimu>',
        '</heimu>'
    ], $heimu_wrapper, $content);
    return $content;
}

add_filter('the_content', 'heimu_guten_tag');
