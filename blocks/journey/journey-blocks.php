<?php
$title    = get_field( 'title' );
$subtitle = get_field( 'sub_title' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel plum-bg text-block white-text <?= $BlockCss; ?>" data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container">
        <div class="head-journey text-block--text snug-child">
            <h2 class=""><?= $title; ?></h2>
            <p class="subtitle-journey"><?= $subtitle; ?></p>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
				<?php if ( have_rows( 'journey' ) ): ?>
					<?php while ( have_rows( 'journey' ) ): the_row();
						$description         = get_sub_field( 'description' );
						$description_wysiwyg = get_sub_field( 'description_wysiwyg' );
						$year                = get_sub_field( 'year' );
						?>
                        <div class="swiper-slide swiper-item" data-year="<?= $year; ?>">
                            <div class="swiper-item-content">
								<?= $description_wysiwyg ?>
                            </div>
                        </div>
					<?php endwhile; ?>
				<?php endif; ?>
            </div>
            <div class="line-yellow"></div>
            <div class="swiper-button-next button-next"></div>
            <div class="swiper-button-prev button-prev"></div>
            <div class="swiper-pagination pagination-item"></div>
        </div>
    </div>
</div>

<script>
    var swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            centeredSlides: true,
            dynamicBullets: true,
            renderBullet: function (index, className) {
                var year = document.querySelectorAll('.swiper-slide')[index].getAttribute('data-year');
                return '<div class="' + className + '">' + '<div class="year">' + year + '</div>' + "</div>";
            },
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
