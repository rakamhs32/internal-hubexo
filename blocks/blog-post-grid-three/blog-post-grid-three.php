<?php
// Add action to handle the category setting
add_action( 'wp_ajax_set_category', 'set_category' );
add_action( 'wp_ajax_nopriv_set_category', 'set_category' );

if ( ! function_exists( 'set_category' ) ) {
	function set_category() {
		if ( isset( $_POST['category_name'] ) ) {
			$category_name = sanitize_text_field( $_POST['category_name'] );
			set_transient( 'category_name', $category_name, 60 * 60 * 24 ); // Store category name for 24 hours
			echo 'Category name set to: ' . $category_name;
		}
		wp_die();
	}
}

// Retrieve the category name from transient
$cat_name = get_transient( 'category_name' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

// Get the posts_per_page from URL parameter or use default
$posts_per_page = isset( $_GET['posts_per_page'] ) ? intval( $_GET['posts_per_page'] ) : 3;
$increment      = 3; // How many more posts to show on each click

$postType = get_field( 'source_post' );
$postCategory = get_field( 'category' );
$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel no-bg card-news <?= the_field( 'color' ) ?> <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container">
        <div class="blog-post-grid sec-post-grid" id="posts-wrap">
	        <?php
	        // Set up query arguments
	        $query_args = [
		        'post_type'      => $postType ? array($postType) : array('post'),
		        'posts_per_page' => $posts_per_page,
		        'post_status'    => 'publish',
		        'orderby'        => 'date',
		        'order'          => 'DESC',
	        ];

	        // Handle category selection from ACF field
	        if (isset($postCategory)) {
		        if (is_array($postCategory)) {
			        $query_args['category__in'] = $postCategory; // For multiple category IDs
		        } else {
			        $query_args['cat'] = $postCategory; // For single category ID
		        }
	        } elseif (isset($category)) {
		        // Fallback to category name (from transient) if ACF field is not set
		        $query_args['category_name'] = $category;
	        }

	        // Perform the query with our arguments
	        $blogs = new WP_Query($query_args);

	        // Store the total found posts and max number of pages
	        $total_posts = $blogs->found_posts;
	        $max_pages   = ceil($total_posts / $posts_per_page);

	        if ($blogs->have_posts()) :
		        $post_count = 0;
		        while ($blogs->have_posts()) :
			        $blogs->the_post();
			        $post_count++;

			        // Posts that were already visible before (for animation)
			        $was_visible = $post_count <= ($posts_per_page - $increment);
			        ?>
                    <div class="blog-post-block fade-in <?= $was_visible ? 'in-view' : '' ?>"
                         data-post-count="<?= $post_count; ?>">
                        <div class="block-link">
                            <div class="image-wrap">
                                <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
                            </div>
                            <div class="blog-post-block--text">
                                <span class="blog-post-block--meta <?= isset( $hide_date ) ? $hide_date : '' ?>">
                                    <span><?php echo get_the_date( 'j M Y' ); ?></span>
                                </span>
                                <h3 class="small-title--bold blog-post-block--title"><?= the_title(); ?></h3>
                                <div class="content-excerpt">
									<?= wp_trim_words( get_the_content(), 20, '...' ); ?>
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
				endwhile;
			else:
				echo esc_html__( 'Sorry, no posts matched your criteria.', 'hubexo' );
			endif;

			wp_reset_postdata();
			?>
        </div>

		<?php if ( $total_posts > $posts_per_page ): ?>
            <div class="text-center" style="margin-top: 30px;">
                <form method="get" class="load-more-form">
                    <!-- Preserve any existing GET parameters -->
					<?php foreach ( $_GET as $key => $value ): ?>
						<?php if ( $key !== 'posts_per_page' ): ?>
                            <input type="hidden" name="<?= esc_attr( $key ) ?>" value="<?= esc_attr( $value ) ?>">
						<?php endif; ?>
					<?php endforeach; ?>

                    <input type="hidden" name="posts_per_page" value="<?= ( $posts_per_page + $increment ) ?>">
                    <button type="submit" class="blueprint--button">
                        Load More
                    </button>
                </form>
            </div>
		<?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add animation for newly loaded posts (those without in-view class)
        setTimeout(function () {
            document.querySelectorAll('.blog-post-block.fade-in:not(.in-view)').forEach(function (item) {
                item.classList.add('in-view');
            });
        }, 100);

        // Scroll to the last previously visible post if we're loading more
		<?php if ($posts_per_page > $increment): ?>
        const lastVisiblePostIndex = <?= $posts_per_page - $increment ?>;
        const scrollTarget = document.querySelector(`.blog-post-block[data-post-count="${lastVisiblePostIndex}"]`);

        if (scrollTarget) {
            // Scroll to where the user was before clicking "Load More"
            window.scrollTo({
                top: scrollTarget.offsetTop - 100, // Added a little offset for better visibility
                behavior: 'auto'
            });
        }
		<?php endif; ?>
    });
</script>

<style>
    /* Fade-in animation */
    .blog-post-block.fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .blog-post-block.fade-in.in-view {
        opacity: 1;
        transform: translateY(0);
    }

    /* Center load more button */
    .text-center {
        text-align: center;
    }
</style>