<?php

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$hide_date     = get_field( 'hide_date' );
$BlockId       = get_field( 'block_id' );
$BlockCss      = get_field( 'block_css' );
$featured_post = get_field( 'featured_post' );

// Check if we have a featured post
if ( $featured_post ):
	// Setup post data to use WordPress template tags
	setup_postdata( $GLOBALS['post'] = $featured_post );

	// Get all the post info we need
	$post_id       = $featured_post;
	$permalink     = get_permalink( $post_id );
	$title         = get_the_title();
	$time          = get_the_time( 'j M Y' );
	$featuredImage = acf_get_attachment( get_post_thumbnail_id( $post_id ) );

	// Get location terms if they exist
	$location  = wp_get_post_terms( $post_id, 'location' );
	$locations = false;
	if ( ! empty( $location ) && ! is_wp_error( $location ) ) {
		$locations = implode( ", ", array_map( function ( $loc ) {
			return $loc->name;
		}, $location ) );
	}
	?>

    <div class="content-panel news-feature <?= $BlockCss ?>"
         data-country="<?= esc_attr( $countries ) ?>"
         id="<?= $BlockId; ?>">
        <div class="container fade-in featured-post--grid">
            <div class="featured-post--image">
				<?php if ( isset( $featuredImage['sizes'] ) ): ?>
                    <picture>
                        <source
                                srcset="<?= $featuredImage['sizes']['mobile']; ?>"
                                media="(max-width: 500px)">
                        <source
                                srcset="<?= $featuredImage['sizes']['large']; ?>">
                        <img
                                src="<?= $featuredImage['sizes']['large']; ?>"
                                loading="lazy"
                                alt="">
                    </picture>
				<?php endif; ?>
            </div>
            <div class="featured-post--text">
                <div class="earth-bg">
                    <span class="blog-post-block--meta">
                        <span class="<?= $hide_date ?>"><?= $time; ?></span>
                        <?php if ( $locations ): ?>
                            <span class="blog-post-block--meta-locations"><?= $locations ?></span>
                        <?php endif ?>
                    </span>
                    <h2 class="h5 featured-post--title"><?= $title; ?></h2>
                    <p><?= get_the_excerpt(); ?></p>
                    <p><a href="<?= $permalink; ?>" class="blueprint--button">View
                            post <?php get_template_part( 'parts/svg/right-arrow' ); ?></a></p>
                </div>
            </div>
        </div>
    </div>

	<?php
	// Reset post data
	wp_reset_postdata();
endif;
?>