<?php

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$postID         = get_option( 'page_for_posts' );
$featured_posts = get_field( 'featured_post', $postID );

$BlockId               = get_field( 'block_id' );
$BlockCss              = get_field( 'block_css' );

if ( $featured_posts ): ?>
	<?php foreach ( $featured_posts as $featured_post ):
		$permalink = get_permalink( $featured_post->ID );
		$title         = get_the_title( $featured_post->ID );
		$time          = get_the_time( 'j M Y' );
		$custom_field  = get_field( 'field_name', $featured_post->ID );
		$featuredImage = acf_get_attachment( get_post_thumbnail_id( $featured_post->ID ) );

		$location  = wp_get_post_terms( $featured_post->ID, 'location' );
		$locations = false;
		if ( ! empty( $location ) && ! is_wp_error( $location ) ) {
			$locations = implode( ", ", array_map( function ( $loc ) {
				return $loc->name;
			}, $location ) );
		}

		if ( is_admin() ) :

			?>
            <div class="container">
                <p>Set this featured post in the news page's custom fields.</p>
            </div>
		<?php endif; ?>


        <div class="news-feature <?= $BlockCss; ?>" data-country="<?= esc_attr( $countries ) ?>" id="<?= $BlockId; ?>">
            <div class="container fade-in featured-post--grid">
                <div class="featured-post--image">
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
                </div>
                <div class="featured-post--text">
                    <div class="earth-bg">
                        <span class="blog-post-block--meta"><span><?= $time; ?></span><?php if ( $locations ): ?><span
                                    class="blog-post-block--meta-locations"><?= $locations ?></span><?php endif ?></span>
                        <h2 class="h5 featured-post--title"><?= $title; ?></h2>
                        <p><?= get_the_excerpt( $featured_post->ID ); ?></p>
                        <p><a href="<?= $permalink; ?>" class="blueprint--button">View
                                post <?php get_template_part( 'parts/svg/right-arrow' ); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
	<?php endforeach; ?>
<?php endif;


get_template_part( 'parts/news/post-list' );

?>