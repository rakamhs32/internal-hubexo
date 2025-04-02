<?php

$stats = get_field( 'stats' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel stats white-text plum-bg <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container">
		<?php if ( ! empty( $stats ) ): ?>
            <div class="stat-blocks">
				<?php foreach ( $stats as $stat ):
					$image = $stat['icon'];
					?>
                    <div class="stat-block">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                        <div class="stat-block--stat">
                            <span class="stat-block--number"><?= $stat['stat']; ?></span>
                            <span class="stat-block--title snug"><?= $stat['description']; ?></span>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
    </div>
</div>