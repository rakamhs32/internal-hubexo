<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Retrieve country data from local storage
        var countryData = localStorage.getItem('country_data');
        if (countryData) {
            countryData = JSON.parse(countryData);
            var categoryName = countryData.iso_code;
            
            // Send category name to PHP
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo admin_url('admin-ajax.php'); ?>", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send("action=set_category&category_name=" + categoryName);
        }
    });
</script>

<?php
// Add action to handle the AJAX request
add_action('wp_ajax_set_category', 'set_category');
add_action('wp_ajax_nopriv_set_category', 'set_category');

function set_category() {
    if (isset($_POST['category_name'])) {
        $category_name = sanitize_text_field($_POST['category_name']);
        set_transient('category_name', $category_name, 60*60*24); // Store category name for 24 hours
        echo 'Category name set to: ' . $category_name;
    }
    wp_die();
}

// Retrieve the category name from transient
$cat_name = get_transient('category_name');
?>

<div class="content-panel no-bg">
    <div class="container">
        <div class="blog-post--grid-title">
            <h2><?= the_field('title') ?></h2>
        </div>
        <div class="blog-post-grid sec-post-grid" id="posts-wrap">
            <?php
            $blogs = new WP_Query([
                'post_type' => array('post'), // Specify post type
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
                        <a href="<?= the_permalink(); ?>" class="block-link">
                            <div class="image-wrap">
                                <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
                            </div>
                            <div class="blog-post-block--text">
                                <span class="blog-post-block--meta"><span><?php echo get_the_date('j M Y'); ?></span>
                                </span>
                                <h3 class="small-title--bold blog-post-block--title"><?= the_title(); ?></h3>
                            </div>
                            <button class="blueprint--button hover">
                                Read more
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.62281 12L19.8828 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                    <path d="M16.4711 19.3846C16.4711 15.3231 19.4249 12 23.0352 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                    <path d="M16.4711 4.61719C16.4711 8.67873 19.4249 12.0018 23.0352 12.0018" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                </svg>
                            </button>
                        </a>
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