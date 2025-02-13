<?php

require_once('inc/constants.php');
require_once('inc/helpers.php');
require_once('inc/images.php');
require_once('inc/menus.php');
require_once('inc/optionsPages.php');
require_once('inc/postTypes.php');
require_once('inc/preGetPosts.php');
require_once('inc/taxonomies.php');
require_once('inc/wysiwyg.php');
require_once('inc/enqueueScripts.php');
require_once('inc/filterHomes.php');
require_once('inc/blocks.php');

function add_custom_class_to_gutenberg_post_content() {
    // Check if we are in the Gutenberg editor and the post type is 'post'
    $screen = get_current_screen();
    if ( $screen && $screen->is_block_editor && $screen->post_type === 'post' ) {
        // Output custom CSS to add the class to the editor
        echo '<style>
            .wp-block-post-content {
                /* Add your custom class */
                max-width: 700px;
                margin-inline: auto;
            }
        </style>';
    }
}
add_action('admin_head', 'add_custom_class_to_gutenberg_post_content');


function add_custom_class_to_gutenberg_page_content() {
    // Check if we are in the Gutenberg editor and the post type is 'page'
    $screen = get_current_screen();
    if ( $screen && $screen->is_block_editor && $screen->post_type === 'page' ) {
        global $post;

        // Check if the page is using the 'template-single-column' page template
        if ( isset( $post ) && get_page_template_slug( $post->ID ) === 'template-single-column.php' ) {
            // Output custom CSS to add the class to the editor
            echo '<style>
                .wp-block-post-content {
                    /* Add your custom class */
                    max-width: 700px;
                    margin-inline: auto;
                }
            </style>';
        }
    }
}
add_action('admin_head', 'add_custom_class_to_gutenberg_page_content');


