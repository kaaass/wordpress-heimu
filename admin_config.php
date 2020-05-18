<?php
/**
 * Admin page
 */

add_action('admin_menu', 'heimu_add_admin_menu');
add_action('admin_init', 'heimu_settings_init');

function heimu_add_admin_menu()
{
    add_submenu_page('plugins.php', __('黑幕', 'Heimu'), __('黑幕', 'Heimu'),
        'manage_options', 'heimu', 'heimu_options_page');
    add_filter('plugin_action_links_' . HEIMU_BASE_NAME, 'heimu_action_links', 10, 2);
}

function heimu_action_links($links, $file)
{
    $settings_link = '<a href="plugins.php?page=heimu">' . __('设置', 'Heimu') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

function heimu_settings_init()
{
    register_setting('pluginPage', 'heimu_settings');

    add_settings_section(
        'heimu_pluginPage_section',
        __('基本配置', 'Heimu'),
        'heimu_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'heimu_text_field_1',
        __('黑幕 Shortcode', 'Heimu'),
        'heimu_text_field_heimu_shortcode_render',
        'pluginPage',
        'heimu_pluginPage_section'
    );

    add_settings_field(
        'heimu_text_field_2',
        __('黑幕悬浮提示', 'Heimu'),
        'heimu_text_field_heimu_float_tips_render',
        'pluginPage',
        'heimu_pluginPage_section'
    );

    add_settings_field(
        'heimu_checkbox_field_0',
        __('启用模糊黑幕', 'Heimu'),
        'heimu_checkbox_heimu_blur_render',
        'pluginPage',
        'heimu_pluginPage_section'
    );
}

function heimu_text_field_heimu_shortcode_render()
{
    global $heimu_options;
    ?>
    <input type='text' name='heimu_settings[heimu_shortcode]'
           value='<?php echo $heimu_options['heimu_shortcode']; ?>'>
    <?php
}


function heimu_text_field_heimu_float_tips_render()
{
    global $heimu_options;
    ?>
    <input type='text' name='heimu_settings[heimu_float_tips]'
           value='<?php echo $heimu_options['heimu_float_tips']; ?>'>
    <?php

}

function heimu_checkbox_heimu_blur_render()
{
    global $heimu_options;
    $blur = isset($heimu_options['blur']) and $heimu_options['blur'] == '1';
    ?>
    <input type='checkbox'
           name='heimu_settings[blur]' <?php checked($blur, 1); ?>
           value='1'>
    <p><?php echo __('使用模糊效果代替纯黑的黑幕。不支持 IE 与部分早期浏览器。', 'Heimu'); ?></p>
    <?php
}

function heimu_settings_section_callback()
{
    echo __('配置黑幕的基本属性', 'Heimu');
}


function heimu_options_page()
{
    ?>
    <form action='options.php' method='post'>

        <h2>黑幕</h2>

        <?php
        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();
        ?>

    </form>
    <?php
}
