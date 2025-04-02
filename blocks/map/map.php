<?php

$image          = get_field( 'map_image' );
$locationBlocks = get_field( 'location_blocks' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel earth-bg map <?= $BlockCss; ?>" data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container">
        <picture>
            <source
                    srcset="<?= $image['sizes']['mobile']; ?>"
                    media="(max-width: 500px)">
            <source
                    srcset="<?= $image['url']; ?>">
            <img
                    src="<?= $image['url']; ?>"
                    loading="lazy"
                    class="fade-in map--image"
                    alt="<?= $image['alt']; ?>">
        </picture>
        <div class="locations fade-in">
            <h2 class="h5"><?= get_field( 'title' ); ?></h2>
            <div class="locations-grid">
				<?php if ( ! empty( $locationBlocks ) ): ?>
					<?php foreach ( $locationBlocks as $i => $locationBlock ):
						$email = $locationBlock['email_address'];
						$email = antispambot( $email );
						?>
                        <div class="location-card" style="--n: <?= $i ?>">
                            <h3 class="snug small-title--bold">
								<?= $locationBlock['title']; ?>
								<?php if ( $locationBlock['icon'] ?? false ): ?>
                                    <img src="<?= $locationBlock['icon']['url'] ?>"
                                         alt="<?= $locationBlock['icon']['alt'] ?>" class="icon-size-medium"/>
								<?php endif; ?>
                            </h3>
                            <p><a href="mailto:<?= $email; ?>" target="_blank" class="blueprint--button">Email
                                    us <?php get_template_part( 'parts/svg/right-arrow' ); ?></a></p>
                        </div>
					<?php endforeach; ?>
				<?php endif; ?>
            </div>

        </div>
    </div>
</div>