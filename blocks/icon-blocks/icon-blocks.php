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

<div class="content-panel icon-blocks <?php if ( $style != "pattern" ): ?>has-image<?php endif; ?> plum-bg <?= $Blockcss; ?>"
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
                    <div class="icon-block" style="--n: <?= $i ?>">
                        <img src="<?= $iconBlock['icon']['url']; ?>" alt="<?= $iconBlock['icon']['alt']; ?>"
                             class="icon-size-default">
                        <h3 class="small-title--bold snug"><?= $iconBlock['title']; ?></h3>
                        <p class="icon-block-description"><?= $iconBlock['text']; ?></p>
						<?php if ( ! empty( $iconBlock['button_url'] ) && ! empty( $iconBlock['button_text'] ) ): ?>
                            <p>
                                <a href="<?= $iconBlock['button_url']; ?>"
                                   class="blueprint--button icon-blocks--button plum-bg <?= $iconBlock['button_style']; ?>"><?= $iconBlock['button_text']; ?><?php get_template_part( 'parts/svg/right-arrow' ); ?></a>
                            </p>
						<?php endif; ?>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
    </div>
</div>