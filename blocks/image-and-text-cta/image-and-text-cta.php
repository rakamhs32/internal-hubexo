<?php

$image = get_field('image');
$linkType = get_field('link_type');
$videoLink = get_field('video_link');
$link = get_field('link');
if (!empty($link)) {
    $link_target = $link['target'] ? $link['target'] : '_self';
}
?>

<div class="content-panel image-and-text-cta">
    <div class="image-and-text-cta--image-wrap">
        <?php if (!empty($image)): ?>
            <picture>
                <source
                    srcset="<?= $image['sizes']['mobile']; ?>"
                    media="(max-width: 500px)">
                <source
                    srcset="<?= $image['url']; ?>">
                <img
                    src="<?= $image['url']; ?>"
                    loading="lazy"
                    alt="<?= $image['alt']; ?>">
            </picture>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="image-cta--text snug-child fade-up">
            <h2><?= get_field('title'); ?></h2>
            <?= get_field('text'); ?>
            <p>
                <?php if ($linkType == "video"): ?>
                    <a href="<?= $videoLink; ?>" class="blueprint--button glightbox-video">
                        Watch now <?php get_template_part('parts/svg/video'); ?>
                    </a>
                <?php elseif ($linkType == "page" && !empty($link)): ?>
                    <a href="<?= $link['url']; ?>" target="<?= esc_attr($link_target); ?>" class="blueprint--button">
                        <?= $link['title']; ?> <?php get_template_part('parts/svg/right-arrow'); ?>
                    </a>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>