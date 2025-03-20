<?php

$title = get_field('title');
$text = get_field('text');
$link = get_field('link');
if (!empty($link)) {
    $link_target = $link['target'] ? $link['target'] : '_self';
}
$stats = get_field('stats');

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}

?>
<div style="display: none !important">
    <!-- This is hidden, but controls the animation -->
    <canvas id="hero-path-canvas" width="25" height="21"></canvas>
</div>

<div class="homepage-banner header-pad-two" data-country="<?= esc_attr($countries) ?>">
    <div class="hero-wrap">
        <div class="hero-inner-wrap">
            <canvas id="hero-circles"></canvas>
        </div>
    </div>
    <?php /* 
    Another old version
    <div class="hero-wrap">
        <div class="hero-inner-wrap">
            <svg id="hero-circles" width="1500" height="1500" viewBox="0 0 1500 1500"></svg>
        </div>
    </div>

    Older version:
    <svg id="hero-circles" width="1500" height="1260" viewBox="0 0 1500 1260"></svg>
    
    Original, image only:
    <img src="<?= get_stylesheet_directory_uri(); ?>/img/home-banner-image.webp" alt="" class="fade-in homepage-banner--bg">
     */ ?>
    <div class="container is-wide">
        <div class="homepage-banner--content">
            <div class="homepage-banner--header-wrap snug-child">
                <h1><?= $title; ?></h1>
            </div>
            <div class="homepage-banner--text snug-child">
                <p class="small-title"><?= $text; ?></p>
                <?php if (!empty($link)): ?>
                    <a href="<?= $link['url']; ?>"
                       class="blueprint--button"><?= $link['title']; ?><?php get_template_part('parts/svg/right-arrow'); ?></a>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($stats)): ?>
            <div class="stat-blocks">
                <?php foreach ($stats as $stat):
                    $image = $stat['icon'];
                    ?>
                    <div class="stat-block">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" class="icon-size-default">
                        <div class="stat-block--stat">
                            <span class="stat-block--number"><?= $stat['stat']; ?></span>
                            <span class="stat-block--title snug"><?= $stat['description']; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php /*
    <svg class="pattern-a is-yellow">
        <g></g>
    </svg>
    */ ?>
</div>