<?php
// Add action to handle the AJAX request
add_action('wp_ajax_set_category', 'set_category');
add_action('wp_ajax_nopriv_set_category', 'set_category');

if (!function_exists('set_category')) {
    function set_category()
    {
        if (isset($_POST['category_name'])) {
            $category_name = sanitize_text_field($_POST['category_name']);
            set_transient('category_name', $category_name, 60 * 60 * 24); // Store category name for 24 hours
            echo 'Category name set to: ' . $category_name;
        }
        wp_die();
    }
}

// Retrieve the category name from transient
$cat_name = get_transient('category_name');

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}

$postType = get_field('source_post');
$textButton = get_field('text_button');
$urlButton = get_field('url_button');
?>

<div class="earth-bg card-news <?= the_field('color') ?>" data-country="<?= esc_attr($countries) ?>">
    <div class="container">
        <div class="blog-post--grid-title">
            <h2 class="h5 snug title-news <?= the_field('color') ?>"><?= the_field('title') ?></h2>
            <?php if (!empty($textButton)): ?>
            <p class="btn-news">
                <a href="<?= $urlButton  ?>"
                   class="blueprint--button icon-blocks--button plum-bg outline-button <?= the_field('color') ?>"><?= $textButton ?><?php get_template_part('parts/svg/right-arrow'); ?></a>
            </p>
        <?php endif; ?>

        </div>
        <div class="blog-post-grid sec-post-grid" id="posts-wrap">
            <?php

            $blogs = new WP_Query([
                'post_type' => $postType ? array($postType) : array('post'), // Use dynamic post type from ACF or fallback to 'post'
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'category_name' => $cat_name, // Use the category name
                'orderby' => 'date',
                'order' => 'DESC',
            ]);

            if ($blogs->have_posts()) :
                $count = 1;
                while ($blogs->have_posts()) : $blogs->the_post();
                    ?>
                    <div class="blog-post-block fade-in">
                        <div class="block-link">
                            <div class="image-wrap">
                                <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
                            </div>
                            <div class="blog-post-block--text">
                                    <span class="blog-post-block--meta">
                                        <span><?php echo get_the_date('j M Y'); ?></span>
                                    </span>
                                <h3 class="small-title--bold blog-post-block--title"><?= the_title(); ?></h3>
                                <div class="content-excerpt">
                                    <?= wp_trim_words(get_the_content(), 20, '...'); ?>
                                </div>
                            </div>
                            <button class="">
                                <a class="blueprint--button hover" href="<?= the_permalink(); ?>">
                                    Read more
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.62281 12L19.8828 12" stroke="currentColor" stroke-width="1.84615"
                                              stroke-miterlimit="10"/>
                                        <path d="M16.4711 19.3846C16.4711 15.3231 19.4249 12 23.0352 12"
                                              stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10"/>
                                        <path d="M16.4711 4.61719C16.4711 8.67873 19.4249 12.0018 23.0352 12.0018"
                                              stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10"/>
                                    </svg>
                                </a>
                            </button>
                        </div>
                    </div>
                    <?php
                    $count++;
                endwhile;
            else :
                echo esc_html__('Sorry, no posts matched your criteria.', 'hubexo');
            endif;

            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>