<?php

$title = get_field( 'title' );
$text  = get_field( 'text' );
$link  = get_field( 'link' );
if ( ! empty( $link ) ) {
	$link_target = $link['target'] ? $link['target'] : '_self';
}
$image = get_field( 'image' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="text-and-image-banner aluminium-bg <?= $BlockCss; ?>" data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="text-and-image-banner--bg-wrap header-pad">
		<?php if ( ! empty( $image ) ): ?>
            <picture>
                <source
                        srcset="<?= $image['sizes']['mobile']; ?>"
                        media="(max-width: 500px)">
                <source
                        srcset="<?= $image['sizes']['large']; ?>">
                <img
                        src="<?= $image['sizes']['large']; ?>"
                        class="text-and-image-banner--bg fade-in"
                        alt="<?= $image['alt']; ?>">
            </picture>
		<?php endif; ?>
        <div class="container">
            <h1 class="h2 snug">
				<?php if ( ! empty( $title ) ): ?>
					<?= $title; ?>
				<?php else: ?>
					<?= the_title(); ?>
				<?php endif; ?>
                ​</h1>
			<?= get_field( 'text' ); ?>
			<?php if ( ! empty( $link ) ): ?>
                <p class="text-and-image-banner--button-wrap">
                    <a href="<?= $link['url']; ?>" target="<?= esc_attr( $link_target ); ?>"
                       class="blueprint--button"><?= $link['title']; ?>
						<?php if ( str_starts_with( $link['url'], "#" ) ): ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.8311 3.79569L10.8311 17.0552" stroke="currentColor" stroke-width="1.84615"
                                      stroke-miterlimit="10"/>
                                <path d="M3.44644 13.642C7.50798 13.642 10.8311 16.5958 10.8311 20.2061"
                                      stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10"/>
                                <path d="M18.2139 13.642C14.1523 13.642 10.8293 16.5958 10.8293 20.2061"
                                      stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10"/>
                            </svg>
						<?php endif; ?>
                    </a>
                </p>
			<?php endif; ?>
        </div>
    </div>
    <svg class="pattern-a is-aluminium">
        <g></g>
    </svg>
</div>