<?php

function blueprint_styles()
{
    add_theme_support('editor-styles');

    add_editor_style('/dist/style.css');
}

add_action('after_setup_theme', 'blueprint_styles');

add_filter('block_categories_all', 'add_custom_block_categories', 10, 2);
function add_custom_block_categories($categories, $post)
{
    array_unshift($categories, [
        'slug'    => 'hubexo',
        'title' => 'Hubexo'
    ]);

    return $categories;
}



function blueprint_register_acf_blocks()
{
    /**
     * We register our block's with WordPress's handy
     * register_block_type();
     *
     * @link https://developer.wordpress.org/reference/functions/register_block_type/
     */
    foreach (glob(get_stylesheet_directory() . '/blocks/*/') as $path) {

        register_block_type($path . 'block.json');
    }
}
// Here we call our blueprint_register_acf_block() function on init.
add_action('init', 'blueprint_register_acf_blocks');
