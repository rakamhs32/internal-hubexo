<?php
$link = get_field('link');
if (!empty($link)) {
    $link_target = $link['target'] ? $link['target'] : '_self';
}
$logo = get_field('logo');
if (!empty($logo)) {
    $logo_url = $logo['url'];
    $logo_alt = $logo['alt'];
    $logo_title = $logo['title'];
}
$image = get_field('image');
if (!empty($image)) {
    $image_url = $image['url'];
    $image_alt = $image['alt'];
    $image_title = $image['title'];
}
$background_image = get_field('background_image');
if (!empty($background_image)) {
    $background_image_url = $background_image['url'];
    $background_image_alt = $background_image['alt'];
    $background_image_title = $background_image['title'];
}

$buttonType = get_field('button_type');

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}
?>
<div class="hero-banner plum-bg header-pad text-block text-block-image white-text head-text--block-section" data-country="<?= esc_attr($countries) ?>">
    <div class="container fade-in">
        <div class="text-block--image">
            <div class="text-block--text content-block--text snug-child">
                <?php if (!empty($logo)): ?>
                    <div class="logo-block--text">
                        <img src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($logo_alt); ?>"
                            title="<?= esc_attr($logo_title); ?>">
                    </div>
                <?php endif; ?>
                <?= get_field('text'); ?>
                <?php if (!empty($link)): ?>
                    <p><a href="<?= $link['url']; ?>" target="<?= esc_attr($link_target); ?>"
                            class="blueprint--button <?= $buttonType ?>"><?= $link['title']; ?><?php get_template_part('parts/svg/right-arrow'); ?></a>
                    </p>
                <?php endif; ?>
            </div>
            <div class="image-block--content">
                <?php if (!empty($image)): ?>
                    <div class="image-block--details">
                        <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($image_alt); ?>"
                            title="<?= esc_attr($image_title); ?>">
                        <?php if (!empty($background_image)): ?>
                            <img class="block-yellow with-bg--image" src="<?= esc_url($background_image_url); ?>" alt="<?= esc_attr($background_image_alt); ?>"
                            title="<?= esc_attr($background_image_title); ?>">
                        <?php else: ?>
                            <div class="block-yellow"></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>