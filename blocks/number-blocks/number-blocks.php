<?php

$title      = get_field( 'title' );
$iconBlocks = get_field( 'icon_blocks' );
$background = get_field( 'background' );
$columns    = get_field( 'columns' );
$style      = get_field( 'style' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel icon-blocks <?php if ( $style != "pattern" ): ?>has-image<?php endif; ?> plum-bg <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
	<?php if ( ! empty( $background ) ): ?>
        <img src="<?= $background['url']; ?>" alt="" class="icon-blocks--background">
	<?php endif; ?>
    <div class="fade-in">
        <div class="container white-text snug-child">
            <h2 class="h5"><?= $title; ?></h2>
        </div>
		<?php if ( ! empty( $iconBlocks ) ): ?>
            <div class="icon-blocks--grid is-<?= $columns; ?> container">
				<?php foreach ( $iconBlocks as $i => $iconBlock ): ?>
                    <div class="icon-block stat-block--stat number-block" style="--n: <?= $i ?>">
                        <!-- <img src="<?= $iconBlock['icon']['url']; ?>" alt="<?= $iconBlock['icon']['alt']; ?>" class="icon-size-default"> -->
                        <h3 class="small-title--bold snug title--number stat-block--number"><?= $iconBlock['title']; ?></h3>
                        <p><?= $iconBlock['text']; ?></p>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
    </div>
</div>