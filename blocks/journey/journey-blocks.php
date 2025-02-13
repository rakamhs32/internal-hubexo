<?php
$title = get_field('title');
$subtitle = get_field('sub_title');
?>

<div class="content-panel plum-bg">
    <div class="container">
        <div class="head-journey">
            <h2 class="title-journey"><?= $title; ?></h2>
            <p class="subtitle-journey"><?= $subtitle; ?></p>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
            <?php if (have_rows('journey')): ?>
                <?php while (have_rows('journey')): the_row();
                    $description = get_sub_field('description');
                    $year = get_sub_field('year');
                ?>
                <div class="swiper-slide swiper-item" data-year="<?= $year; ?>">
                    <div class="swiper-item-content">
                        <?= $description ?>
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
            renderBullet: function(index, className) {
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
