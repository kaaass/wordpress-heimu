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
        'heimu_section_basic',
        __('基本配置', 'Heimu'),
        'heimu_settings_section_callback',
        'heimu_config_page'
    );

    add_settings_field(
        'heimu_text_field_1',
        __('黑幕 Shortcode', 'Heimu'),
        'heimu_text_field_heimu_shortcode_render',
        'heimu_config_page',
        'heimu_section_basic'
    );

    add_settings_field(
        'heimu_text_field_2',
        __('黑幕悬浮提示', 'Heimu'),
        'heimu_text_field_heimu_float_tips_render',
        'heimu_config_page',
        'heimu_section_basic'
    );

    add_settings_field(
        'heimu_checkbox_field_0',
        __('启用模糊黑幕', 'Heimu'),
        'heimu_checkbox_heimu_blur_render',
        'heimu_config_page',
        'heimu_section_basic'
    );

    add_settings_field(
        'heimu_checkbox_field_1',
        __('允许评论区使用黑幕', 'Heimu'),
        'heimu_checkbox_heimu_comment_shortcode_render',
        'heimu_config_page',
        'heimu_section_basic'
    );

    add_settings_section(
        'heimu_section_guten',
        __('区块编辑器', 'Heimu'),
        'heimu_settings_section_callback',
        'heimu_config_page'
    );

    add_settings_field(
        'heimu_checkbox_enable_guten',
        __('禁用区块编辑器支持', 'Heimu'),
        'heimu_checkbox_enable_guten_render',
        'heimu_config_page',
        'heimu_section_guten'
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

function heimu_checkbox_enable_guten_render()
{
    global $heimu_options;
    $guten = isset($heimu_options['disable_guten']) and $heimu_options['disable_guten'] == '1';
    ?>
    <input type='checkbox'
           name='heimu_settings[disable_guten]' <?php checked($guten, 1); ?>
           value='1'>
    <p><?php echo __('本选项开启后则禁止在区块编辑器中使用可视化编辑黑幕，并关闭快捷键 <code>Ctrl + H</code>。', 'Heimu'); ?></p>
    <p><?php echo __('注意，由于目前 WordPress API 所限，因此可视化编辑目前采用的是 Html 标签进行实现。因此关闭时，您通过可视化编辑产生的黑幕都将失效。', 'Heimu'); ?></p>
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
