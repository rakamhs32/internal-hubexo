<?php

$link = get_field( 'link' );
if ( ! empty( $link ) ) {
	$link_target = $link['target'] ? $link['target'] : '_self';
}

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel text-block white-text plum-bg <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container fade-in">
        <div class="text-block--text snug-child">
			<?= get_field( 'text' ); ?>
			<?php if ( ! empty( $link ) ): ?>
                <p><a href="<?= $link['url']; ?>" target="<?= esc_attr( $link_target ); ?>"
                      class="blueprint--button"><?= $link['title']; ?><?php get_template_part( 'parts/svg/right-arrow' ); ?></a>
                </p>
			<?php endif; ?>
        </div>
    </div>
</div>