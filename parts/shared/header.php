<?php get_template_part( 'parts/shared/float-btn' ); ?>
<header class="site-header at-top <?= is_front_page() ? 'hide' : '' ?>" id="header">
	<?php get_template_part( 'parts/shared/header/header-message' ); ?>
	<?php get_template_part( 'parts/shared/header/location-bar' ); ?>
    <div class="container is-wide site-header--container">
		<?php get_template_part( 'parts/shared/header/search-bar-mobile' ); ?>
        <div class="site-header--home-link">
            <a href="<?= get_home_url(); ?>">
				<?php get_template_part( 'parts/svg/logo' ); ?>
                <span class="sr-only"><?php echo get_bloginfo( 'name' ); ?> homepage</span>
            </a>
        </div>
        <nav class="header-nav">

			<?php wp_nav_menu( [
				"theme_location" => "main",
				'link_before'    => '<span>',
				'link_after'     => '</span>
				<span class="mobile-button">
					<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.00032 0.812816V13.1872" stroke="#DCFF3C" stroke-width="2" stroke-miterlimit="10"/>
						<path d="M13.1875 7H0.813132" stroke="#DCFF3C" stroke-width="2" stroke-miterlimit="10"/>
					</svg>
				</span>'
			] )
			?>

			<?php get_template_part( 'parts/shared/header/search-bar' ); ?>
            <div class="menu-button">
                <button class="search-mobile-button" id="searchMobileButton">
                    <!-- <span class="hamburger--text"><?php _e( 'Menu', 'hubexo' ); ?></span> -->
                    <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         viewBox="0,0,256,256" width="30px" height="30px"
                                                         fill-rule="nonzero"><g fill="#321432" fill-rule="nonzero"
                                                                                stroke="none" stroke-width="1"
                                                                                stroke-linecap="butt"
                                                                                stroke-linejoin="miter"
                                                                                stroke-miterlimit="10"
                                                                                stroke-dasharray=""
                                                                                stroke-dashoffset="0" font-family="none"
                                                                                font-weight="none" font-size="none"
                                                                                text-anchor="none"
                                                                                style="mix-blend-mode: normal"><g
                                                                    transform="scale(5.12,5.12)"><path
                                                                        d="M21,3c-9.39844,0 -17,7.60156 -17,17c0,9.39844 7.60156,17 17,17c3.35547,0 6.46094,-0.98437 9.09375,-2.65625l12.28125,12.28125l4.25,-4.25l-12.125,-12.09375c2.17969,-2.85937 3.5,-6.40234 3.5,-10.28125c0,-9.39844 -7.60156,-17 -17,-17zM21,7c7.19922,0 13,5.80078 13,13c0,7.19922 -5.80078,13 -13,13c-7.19922,0 -13,-5.80078 -13,-13c0,-7.19922 5.80078,-13 13,-13z"></path></g></g></svg>
                                                 </span>
                </button>
                <button class="hamburger" id="hamburger">
                    <!-- <span class="hamburger--text"><?php _e( 'Menu', 'hubexo' ); ?></span> -->
                    <span class="hamburger--icon">
                					<?php get_template_part( 'parts/svg/burger' ); ?>
                				</span>
                </button>
            </div>
        </nav>
    </div>
</header>
