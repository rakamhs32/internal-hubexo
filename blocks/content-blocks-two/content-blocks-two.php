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
?>
<div class="hero-banner plum-bg header-pad text-block text-block-image white-text head-text--block-section">
    <div class="container fade-in container-overflowhidden">
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
                          class="blueprint--button"><?= $link['title']; ?><?php get_template_part('parts/svg/right-arrow'); ?></a>
                    </p>
                <?php endif; ?>
            </div>
            <div class="image-block--content">
                <?php if (!empty($image)): ?>
                    <div class="image-block--details">
                        <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($image_alt); ?>"
                             title="<?= esc_attr($image_title); ?>">
                        <div class="block-yellow-two"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>