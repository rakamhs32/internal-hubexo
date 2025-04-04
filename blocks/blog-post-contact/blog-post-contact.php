<?php
$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$title    = get_field( 'title' );
$email    = get_field( 'email' );
$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
$email    = antispambot( $email );

?>

<div class="location-card blog-post-contact is-yellow <?= $BlockCss; ?>" data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <h3 class="snug">
        <span><?= $title; ?></span>
        <svg width="26" height="19" viewBox="0 0 26 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                    d="M22.5531 2.27075L16.1039 8.71998L15.7593 9.11383C14.1839 10.6892 11.6731 10.6892 10.0977 9.11383L9.85157 8.86768L3.40234 2.36921"
                    stroke="#321432" stroke-width="2.46154" stroke-miterlimit="10"></path>
            <path
                    d="M20.0896 1.43384H5.96035C3.74496 1.43384 1.97266 3.20615 1.97266 5.42153V5.17538V13.0523V13.3969C1.97266 15.6123 3.74496 17.3846 5.96035 17.3846H20.1388C22.3542 17.3846 24.1265 15.6123 24.1265 13.3969V5.71691V5.47076C24.1265 3.25538 22.305 1.43384 20.0896 1.43384Z"
                    stroke="#321432" stroke-width="2.46154" stroke-miterlimit="10"></path>
        </svg>
    </h3>
    <p class="snug"><a href="mailto:<?= $email; ?>" class="small-title--bold"><?= $email; ?></a></p>
</div>