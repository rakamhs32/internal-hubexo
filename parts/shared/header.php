<header class="site-header at-top <?= is_front_page() ? 'hide' : '' ?>" id="header">
	<?php get_template_part('parts/shared/header/header-message'); ?>
	<?php get_template_part('parts/shared/header/location-bar'); ?>
	<div class="container is-wide site-header--container">
		<div class="site-header--home-link">
			<a href="<?= get_home_url(); ?>">
				<?php get_template_part('parts/svg/logo'); ?>
				<span class="sr-only"><?php echo get_bloginfo('name'); ?> homepage</span>
			</a>
		</div>
		<nav class="header-nav">

			<?php wp_nav_menu([
				"theme_location" => "main",
				'link_before' => '<span>',
				'link_after' => '</span>
				<span class="mobile-button">
					<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.00032 0.812816V13.1872" stroke="#DCFF3C" stroke-width="2" stroke-miterlimit="10"/>
						<path d="M13.1875 7H0.813132" stroke="#DCFF3C" stroke-width="2" stroke-miterlimit="10"/>
					</svg>
				</span>'
			])
			?>
			<button class="hamburger" id="hamburger">
				<span class="hamburger--text"><?php _e('Menu', 'hubexo'); ?></span>
				<span class="hamburger--icon">
					<?php get_template_part('parts/svg/burger'); ?>
				</span>
			</button>
		</nav>
	</div>

</header>