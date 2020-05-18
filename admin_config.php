<?php
/**
 * Admin page
 */

add_action('admin_menu', 'heimu_add_admin_menu');
add_action('admin_init', 'heimu_settings_init');

function heimu_add_admin_menu()
{
    add_submenu_page('options-general.php', __('黑幕', 'Heimu'), __('黑幕', 'Heimu'),
        'manage_options', 'heimu', 'heimu_options_page');
    add_filter('plugin_action_links_' . HEIMU_BASE_NAME, 'heimu_action_links', 10, 2);
}

function heimu_action_links($links, $file)
{
    $settings_link = '<a href="options-general.php?page=heimu">' . __('设置', 'Heimu') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

function heimu_settings_init()
{
    register_setting('heimu_config_page', 'heimu_settings');

    add_settings_section(
        'heimu_pluginPage_section',
        __('基本配置', 'Heimu'),
        'heimu_settings_section_callback',
        'heimu_config_page'
    );

    add_settings_field(
        'heimu_text_field_1',
        __('黑幕 Shortcode', 'Heimu'),
        'heimu_text_field_heimu_shortcode_render',
        'heimu_config_page',
        'heimu_pluginPage_section'
    );

    add_settings_field(
        'heimu_text_field_2',
        __('黑幕悬浮提示', 'Heimu'),
        'heimu_text_field_heimu_float_tips_render',
        'heimu_config_page',
        'heimu_pluginPage_section'
    );

    add_settings_field(
        'heimu_checkbox_field_0',
        __('启用模糊黑幕', 'Heimu'),
        'heimu_checkbox_heimu_blur_render',
        'heimu_config_page',
        'heimu_pluginPage_section'
    );

    add_settings_field(
        'heimu_checkbox_field_1',
        __('允许评论区使用黑幕', 'Heimu'),
        'heimu_checkbox_heimu_comment_shortcode_render',
        'heimu_config_page',
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

function heimu_checkbox_heimu_comment_shortcode_render()
{
    global $heimu_options;
    $comment = isset($heimu_options['comment_shortcode']) and $heimu_options['comment_shortcode'] == '1';
    ?>
    <input type='checkbox'
           name='heimu_settings[comment_shortcode]' <?php checked($comment, 1); ?>
           value='1'>
    <p><?php echo __('本选项开启后则允许在评论区中使用黑幕 Shortcode。', 'Heimu'); ?></p>
    <p><?php echo __('注意，出于安全考虑，本选项只对黑幕 Shortcode 生效，其他 Shortcode 在评论区依旧无法使用。', 'Heimu'); ?></p>
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
        settings_fields('heimu_config_page');
        do_settings_sections('heimu_config_page');
        submit_button();
        ?>

    </form>
    <?php
}
