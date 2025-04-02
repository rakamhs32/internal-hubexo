<div class="content-panel no-bg">
	<div class="container">
		<div class="blog-post-grid" id="posts-wrap">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part('parts/news/news-post-block'); ?>
				<?php endwhile; ?>
				<div class="navigation pagination">
					<?php next_posts_link(__('Load more', 'hubexo'), 0); ?>
				</div>

		</div>

	<?php else : ?>
		<p><?php esc_html_e('Sorry, no posts matched your criteria.', 'hubexo'); ?></p>
	<?php endif; ?>
	</div>
</div>