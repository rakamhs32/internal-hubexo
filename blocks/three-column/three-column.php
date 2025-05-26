<?php
$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel three-column earth-bg <?= $BlockCss; ?>" <?= getBlockId( $block ) ?>
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container snug-child text-block fade-in">
        <h2><?= get_field( 'title' ); ?></h2>
        <div class="three-column--grid">
            <div class="three-column--column snug-child">
				<?= get_field( 'column_one' ); ?>
            </div>
            <div class="three-column--column snug-child">
				<?= get_field( 'column_two' ); ?>
            </div>
            <div class="three-column--column snug-child">
				<?= get_field( 'column_three' ); ?>
            </div>
        </div>
    </div>
</div>