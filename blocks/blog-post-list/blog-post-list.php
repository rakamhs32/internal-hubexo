<?php
$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

// Get category if set
$category = get_transient( 'category_name' ) ? get_transient( 'category_name' ) : '';

// Get the posts_per_page from URL parameter, session, or use default
$posts_per_page = isset( $_GET['posts_per_page'] ) ? intval( $_GET['posts_per_page'] ) : 5;
$increment      = 5; // How many more posts to show on each click

$postType = get_field( 'source_post' );
$postCategory = get_field( 'category' );
$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="no-bg content-panel <?= the_field( 'color' ) ?> <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container">
        <h2 class="h5 snug title-news <?= the_field( 'color' ) ?>"><?= the_field( 'title' ) ?></h2>
        <div class="posts-container" id="posts-wrap">
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
                    <div class="blog-post-item blog-item-list fade-in <?= $was_visible ? 'in-view' : '' ?>"
                         data-post-count="<?= $post_count; ?>">
                        <div class="blog-post-list--text">
                            <span class="blog-post-block--meta">
                                <span><?php echo get_the_date( 'j M Y' ); ?></span>
                            </span>
                            <a class="" href="<?= the_permalink(); ?>">
                                <h3 class="blog-post-list--title <?= the_field( 'color' ) ?>"><?= the_title(); ?></h3>
                            </a>
                            <div class="content-excerpt <?= the_field( 'color' ) ?>">
								<?= wp_trim_words( get_the_content(), 20, '...' ); ?>
                            </div>
                        </div>
                    </div>
				<?php
				endwhile;
			else :
				echo esc_html__( 'Sorry, no posts matched your criteria.', 'hubexo' );
			endif;

			wp_reset_postdata();
			?>
        </div>

        <!-- Load More Button -->
		<?php if ( $total_posts > $posts_per_page ) : ?>
            <div class="load-more-wrap">
                <form method="get" class="load-more-form">
                    <!-- Preserve any existing GET parameters -->
					<?php foreach ( $_GET as $key => $value ): ?>
						<?php if ( $key !== 'posts_per_page' ): ?>
                            <input type="hidden" name="<?= esc_attr( $key ) ?>" value="<?= esc_attr( $value ) ?>">
						<?php endif; ?>
					<?php endforeach; ?>

                    <input type="hidden" name="posts_per_page" value="<?= ( $posts_per_page + $increment ) ?>">
                    <button type="submit" id="load-more" class="load-more-button">
						<?= the_field( 'text_button' ) ?>
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
            document.querySelectorAll('.blog-post-item.fade-in:not(.in-view)').forEach(function (item) {
                item.classList.add('in-view');
            });
        }, 100);

        // Scroll to the last previously visible post if we're loading more
		<?php if ($posts_per_page > $increment): ?>
        const lastVisiblePostIndex = <?= $posts_per_page - $increment ?>;
        const scrollTarget = document.querySelector(`.blog-post-item[data-post-count="${lastVisiblePostIndex}"]`);

        if (scrollTarget) {
            // Scroll to where the user was before clicking "Load More"
            window.scrollTo({
                top: scrollTarget.offsetTop,
                behavior: 'auto'
            });
        }
		<?php endif; ?>
    });
</script>

<style>
    /* Fade-in animation */
    .blog-post-item.fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .blog-post-item.fade-in.in-view {
        opacity: 1;
        transform: translateY(0);
    }

    /* Button styling */
    .load-more-button {
        /* Copy your button styling here */
        cursor: pointer;
    }
</style>