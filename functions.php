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
function add_custom_class_to_gutenberg_post_content()
{
	// Check if we are in the Gutenberg editor and the post type is 'post'
	$screen = get_current_screen();
	if ($screen && $screen->is_block_editor && $screen->post_type === 'post') {
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
function add_custom_class_to_gutenberg_page_content()
{
	// Check if we are in the Gutenberg editor and the post type is 'page'
	$screen = get_current_screen();
	if ($screen && $screen->is_block_editor && $screen->post_type === 'page') {
		global $post;
		// Check if the page is using the 'template-single-column' page template
		if (isset($post) && get_page_template_slug($post->ID) === 'template-single-column.php') {
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
// Add this code to your theme's functions.php file
function allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter('upload_mimes', 'allow_svg_upload');
// Additional security check for SVG uploads
function check_svg_upload($data, $file, $filename, $mimes)
{
	$filetype = wp_check_filetype($filename, $mimes);
	if ('svg' === $filetype['ext']) {
		// Verify that the file is actually SVG
		$svg_content = file_get_contents($file['tmp_name']);
		// Basic security check - verify it's an SVG
		if (false === strpos($svg_content, '<svg')) {
			$data['error'] = __('Sorry, this file is not a valid SVG.');
		}
	}
	return $data;
}

add_filter('wp_check_filetype_and_ext', 'check_svg_upload', 10, 4);
function hubexo_custom_search_ajax()
{
	$search_query = sanitize_text_field($_GET['query']);
	$args = array(
		'post_type' => ['post', 'post-media', 'post-resources', 'page'], // Adjust as needed
		'posts_per_page' => 5,
		's' => $search_query,
		'orderby' => 'relevance'
	);
	$search_query = new WP_Query($args);
	$results = [];
	if ($search_query->have_posts()) {
		while ($search_query->have_posts()) {
			$search_query->the_post();
			$results[] = array(
				'title' => get_the_title(),
				'link' => get_permalink(),
				'excerpt' => get_the_excerpt(),
				'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: '',
				'post_type' => $post_type, // Include post type in results
				'post_type_label' => get_post_type_object($post_type)->labels->singular_name // Get readable post type name
			);
		}
		wp_reset_postdata();
	}
	wp_send_json_success($results);
	wp_die();
}

add_action('wp_ajax_hubexo_search', 'hubexo_custom_search_ajax');
add_action('wp_ajax_nopriv_hubexo_search', 'hubexo_custom_search_ajax');
// Enqueue scripts
function hubexo_enqueue_search_scripts()
{
	wp_enqueue_script('hubexo-search', get_template_directory_uri() . '/assets/js/modules/locationBar.js', false, false, false);
	wp_localize_script('hubexo-search', 'wp_ajax_object', [
		'ajax_url' => admin_url('admin-ajax.php')
	]);
}

add_action('wp_enqueue_scripts', 'hubexo_enqueue_search_scripts');
// Change admin menu labels
function change_admin_menu_labels()
{
	global $menu;
	global $submenu;
	// Change Posts to News
	if (isset($menu[5]) && is_array($menu[5]) && $menu[5][0] === 'Posts') {
		$menu[5][0] = 'News';
	}
	// Change Posts submenu
	if (isset($submenu['edit.php'])) {
		foreach ($submenu['edit.php'] as $key => $item) {
			switch ($item[0]) {
				case 'All Posts':
					$submenu['edit.php'][$key][0] = 'All News';
					break;
				case 'Add New Post':
					$submenu['edit.php'][$key][0] = 'Add New News';
					break;
			}
		}
	}
	// Change Media to Gallery
	if (isset($menu[10]) && is_array($menu[10]) && $menu[10][0] === 'Media') {
		$menu[10][0] = 'Gallery';
	}
	// Change Media submenu
	if (isset($submenu['upload.php'])) {
		foreach ($submenu['upload.php'] as $key => $item) {
			switch ($item[0]) {
				case 'Library':
					$submenu['upload.php'][$key][0] = 'Gallery';
					break;
				case 'Add New':
					$submenu['upload.php'][$key][0] = 'Add New';
					break;
			}
		}
	}
}

add_action('admin_menu', 'change_admin_menu_labels');
// Change post labels throughout WordPress
function change_post_labels()
{
	global $wp_post_types;
	if (isset($wp_post_types['post'])) {
		$labels = &$wp_post_types['post']->labels;
		$labels->name = 'News';
		$labels->singular_name = 'News';
		$labels->add_new = 'Add News';
		$labels->add_new_item = 'Add News';
		$labels->edit_item = 'Edit News';
		$labels->new_item = 'News';
		$labels->view_item = 'View News';
		$labels->search_items = 'Search News';
		$labels->not_found = 'No News found';
		$labels->not_found_in_trash = 'No News found in Trash';
		$labels->all_items = 'All News';
		$labels->menu_name = 'News';
		$labels->name_admin_bar = 'News';
	}
}

add_action('init', 'change_post_labels');
// Filter the "Enter title here" text
function change_title_text($title)
{
	$screen = get_current_screen();
	if ('post' == $screen->post_type) {
		$title = 'Enter news title';
	}
	return $title;
}

add_filter('enter_title_here', 'change_title_text');
function modify_search_query($query)
{
	if ($query->is_search && !is_admin() && $query->is_main_query()) {
		$query->set('posts_per_page', 6); // Set limit to 6 posts per page
		$query->set('post_type', array('post', 'post-page', 'post-resources', 'post-media', 'page')); // Include your custom post types
	}
	return $query;
}

add_action('pre_get_posts', 'modify_search_query');
function custom_rewrite_rules()
{
	add_rewrite_rule(
		'resource/page/?([0-9]{1,})/?$',
		'index.php?pagename=resource&paged=$matches[1]',
		'top'
	);
}

add_action('init', 'custom_rewrite_rules');
// After adding this, go to WordPress Admin → Settings → Permalinks
// and just click "Save Changes" to flush the rewrite rules
// custom for footer-addon
class Separator_Walker_Nav_Menu_1 extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$classes = empty($item->classes) ? array() : (array)$item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		$output .= '<li' . $id . $class_names . '>';
		$atts = array();
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
		$atts['href'] = !empty($item->url) ? $item->url : '';
		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (!empty($value)) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$title = apply_filters('the_title', $item->title, $item->ID);
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		// Add separator if not the last item
		if (!empty($args->menu_id) && $args->menu_id === 'menu-footer-addon-1') {
			$output .= ' | ';
		}
	}

	function end_el(&$output, $item, $depth = 0, $args = null)
	{
		$output = rtrim($output, ' | '); // Remove trailing separator
		$output .= "</li>\n";
	}
}

class Separator_Walker_Nav_Menu extends Walker_Nav_Menu
{
	private $is_first_item = true; // Track the first item

	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		// Add separator for all items except the first one
		if (!$this->is_first_item) {
			$output .= ' | ';
		}
		$this->is_first_item = false;
		$classes = empty($item->classes) ? array() : (array)$item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		$output .= '<li' . $id . $class_names . '>';
		$atts = array();
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
		$atts['href'] = !empty($item->url) ? $item->url : '';
		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (!empty($value)) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$title = apply_filters('the_title', $item->title, $item->ID);
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	function end_el(&$output, $item, $depth = 0, $args = null)
	{
		$output .= "</li>\n";
	}
}
