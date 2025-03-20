<?php
$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}

$bannerBg = get_field('banner_background');

if ($bannerBg && $bannerBg != "none") {
    get_template_part("blocks/column-banner/pattern-column-banner");
} else {

    $title = get_field('title');
    $link = get_field('link');
    $image = get_field('image');
    $position = get_field('position');
    $use_mask = get_field('use_mask') ?? false;
    if (!empty($link)) {
        $link_target = $link['target'] ? $link['target'] : '_self';
    }

?>

    <div class="hero-banner plum-bg header-pad" data-country="<?= esc_attr($countries) ?>">
        <div class="container snug-child <?= $position ?>">
            <h1 class="h2">
                <?php if (!empty($title)): ?>
                    <?= $title; ?>
                <?php else: ?>
                    <?= the_title(); ?>
                <?php endif; ?>
            </h1>
            <?= get_field('text'); ?>
            <?php if (!empty($link)): ?>
                <p class="hero-banner--button-wrap">
                    <a href="<?= $link['url']; ?>" target="<?= esc_attr($link_target); ?>" class="blueprint--button"><?= $link['title']; ?>
                        <?php if (str_starts_with($link['url'], "#")): ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.8311 3.79569L10.8311 17.0552" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                <path d="M3.44644 13.642C7.50798 13.642 10.8311 16.5958 10.8311 20.2061" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                <path d="M18.2139 13.642C14.1523 13.642 10.8293 16.5958 10.8293 20.2061" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                            </svg>
                        <?php else: ?>
                            <?php get_template_part('parts/svg/right-arrow'); ?>
                        <?php endif; ?>
                    </a>
                </p>
            <?php endif; ?>
        </div>
        <?php if ($image): ?>
            <div class="hero-banner--image column-banner--image <?= $position ?> <?= $use_mask ? "use-mask" : '' ?>">
                <img src="<?= $image['sizes']['large'] ?>" alt="<?= $image['alt'] ?>" />
            </div>
        <?php endif; ?>
        <?php /* if ($bannerBg == "none"): ?>
        <svg class="pattern-a is-aluminium">
            <g></g>
        </svg>
    <?php endif; */ ?>
    </div>
<?php
}
?>