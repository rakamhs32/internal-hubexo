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
<div class="content-panel yellow-bg centered-text-panel text-center <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container snug-child fade-in">
		<?= get_field( 'text' ); ?>
    </div>
</div>