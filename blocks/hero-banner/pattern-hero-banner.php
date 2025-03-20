<?php
$title = get_field('title');
$bannerBg = get_field('banner_background');
$link = get_field('link');
if (!empty($link)) {
    $link_target = $link['target'] ? $link['target'] : '_self';
}

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}

?>

<div class="hero-banner plum-bg header-pad <?php if ($bannerBg != "none"): ?>has-pattern<?php endif; ?>" data-country="<?= esc_attr($countries) ?>">
    <div class="container snug-child">
        <h1 class="h2">
            <?php if (!empty($title)): ?>
                <?= $title; ?>
            <?php else: ?>
                <?= the_title(); ?>
            <?php endif; ?>
        </h1>
        <?= get_field('text'); ?>
        <?php if (!empty($link)): ?>
            <p class="hero-banner--button-wrap"><a href="<?= $link['url']; ?>" target="<?= esc_attr($link_target); ?>"
                                                   class="blueprint--button"><?= $link['title']; ?><?php get_template_part('parts/svg/right-arrow'); ?></a>
            </p>
        <?php endif; ?>
    </div>
    <?php if ($bannerBg == "none"): ?>
        <svg class="pattern-a is-aluminium">
            <g></g>
        </svg>
    <?php endif; ?>
</div>