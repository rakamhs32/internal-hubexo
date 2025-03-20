<?php

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}

$Categories = get_field('categories');
$Post_type = get_field('post_type');
$Content_type = get_field('content_type');

// Get the current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Get the sort order from URL parameter or default to 'DESC'
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'DESC';

// Get posts per page from URL parameter or default to 20
$posts_per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 5;

// Prepare post types array
$post_types = $Post_type ? $Post_type : array('post', 'media');

// Initialize $category_names with a default value
$category_names = '';

// Prepare categories
if ($Categories && !empty($Categories)) {
    if (is_array($Categories)) {
        $category_names = implode(',', array_map(function ($cat) {
            return $cat->slug;
        }, $Categories));
    } else if (is_object($Categories)) {
        $category_names = $Categories->slug;
    } else {
        $category_names = $Categories; // If it's a string, use it directly
    }
}

$args = array(
    'post_type' => $post_types,
    'posts_per_page' => $posts_per_page,
    'post_status' => 'publish',
    'category_name' => $category_names,
    'orderby' => 'date',
    'order' => $sort_order,
    'paged' => $paged
);

if (!function_exists('get_custom_breadcrumb')) {
    function get_custom_breadcrumb()
    {
        $output = '<a href="' . home_url() . '">Home</a>';

        if (is_singular()) {
            if (is_page()) {
                // Get all parent pages
                $parents = get_post_ancestors(get_the_ID());

                // Reverse the array to display the hierarchy from highest to lowest
                $parents = array_reverse($parents);

                // Add all parent pages to breadcrumb
                foreach ($parents as $parent_id) {
                    $output .= ' > <a href="' . get_permalink($parent_id) . '">' . get_the_title($parent_id) . '</a>';
                }

                // Add current page title
                $output .= ' > ' . get_the_title();
            } else {
                // Handle non-page post types as before
                $post_type = get_post_type_object(get_post_type());

                if ($post_type->name !== 'page') {
                    $output .= ' > <a href="' . get_post_type_archive_link($post_type->name) . '">'
                        . $post_type->label . '</a>';

                    $categories = get_the_category();
                    if ($categories) {
                        $category = $categories[0];
                        $output .= ' > <a href="' . get_category_link($category->term_id) . '">'
                            . $category->name . '</a>';
                    }
                }

                $output .= ' > ' . get_the_title();
            }
        } elseif (is_archive()) {
            if (is_category()) {
                $output .= ' > ' . single_cat_title('', false);
            } elseif (is_post_type_archive()) {
                $output .= ' > ' . post_type_archive_title('', false);
            }
        }

        return $output;
    }
}

$query = new WP_Query($args);

global $wp;
$current_url = home_url($wp->request);
$base_url = rtrim(get_permalink(), '/');

?>

<div class="title-banner <?php echo $Content_type ?>" data-country="<?= esc_attr($countries) ?>">
    <div class="container snug-child">
        <div class="title-and-permalink">
            <div class="source-link">
                <?php echo get_custom_breadcrumb(); ?>
            </div>
            <div class="title-page-custom">
                <h1 class="h2"><?php echo the_title(); ?></h1>
            </div>
            <div>
                <?php echo the_excerpt(); ?>
            </div>
        </div>
    </div>
    <div class="container snug-child" style="margin-top: 5rem;">
        <div class="nav-article">
            <div class="article-nav-next-prev">
                <div class="article-nav-prev">
                    <button <?php echo ($paged > 1) ? 'onclick="window.location.href=\'' . add_query_arg('paged', ($paged - 1), $current_url) . '\'"' : 'disabled'; ?>>
                        <span class="arrow">←</span> Prev
                    </button>
                </div>
                <div class="article-nav-next">
                    <?php if ($paged < $query->max_num_pages) : ?>
                        <button
                            onclick="window.location.href='<?php echo add_query_arg('paged', ($paged + 1), $current_url); ?>'">
                            Next <span class="arrow">→</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="article-sortby">
                <div class="sort-by">
                    <label for="sort-select">Sort By:</label>
                    <div class="select-article-button">
                        <select id="sort-select" onchange="updateQueryParams('sort', this.value)">
                            <option value="DESC" <?php selected($sort_order, 'DESC'); ?>>Newest First</option>
                            <option value="ASC" <?php selected($sort_order, 'ASC'); ?>>Oldest First</option>
                        </select>
                        <div class="sort-date"></div>
                    </div>
                </div>
                <!-- <div class="result-page">
                    <label for="per-page-select">Show:</label>
                    <div class="select-article-button">
                        <select id="per-page-select" onchange="updateQueryParams('per_page', this.value)">
                            <option value="5" <?php selected($posts_per_page, 5); ?>>5</option>
                            <option value="10" <?php selected($posts_per_page, 10); ?>>10</option>
                            <option value="20" <?php selected($posts_per_page, 20); ?>>20</option>
                            <option value="50" <?php selected($posts_per_page, 50); ?>>50</option>
                        </select>
                        <div class="sort-by-page"></div>
                    </div>
                    <span>per page</span>
                </div>-->
            </div>
        </div>

        <div class="article-list-post">
            <?php if ($query->have_posts()) : ?>
                <div class="search-results-grid">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>


                        <article>
                            <div class="search-result-content">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="search-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="search-text-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>
                                        <div class="post-meta">
                                            <span class="post-type-label">
                                                <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                            </span>
                                            <span>|</span>
                                            <span class="post-date">
                                                <?php echo get_the_date(); ?>
                                            </span>
                                        </div>
                                    </header>

                                    <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                // Temporarily store the main query
                $temp_query = $GLOBALS['wp_query'];
                // Make your custom query the main query
                $GLOBALS['wp_query'] = $query;

                // Output the pagination
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'your-theme-text-domain'),
                    'next_text' => __('Next', 'your-theme-text-domain'),
                    'class' => 'pagination-search',
                    'screen_reader_text' => ' ',
                ));

                // Restore the main query
                $GLOBALS['wp_query'] = $temp_query;
                wp_reset_postdata();
                ?>


            <?php else : ?>
                <div class="no-results">
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'your-theme-text-domain'); ?></p>
                    <!-- <?php get_search_form(); ?> -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function updateQueryParams(param, value) {
        const url = new URL(window.location.href);
        url.searchParams.set(param, value);
        window.location.href = url.toString();
    }
</script>
