<?php
$image = get_field('map_image');
$locationBlocks = get_field('location_blocks');
?>

<div class="content-panel earth-bg map map-office">
    <div class="container">
        <?php if (!empty($image)): ?>
            <picture>
                <source
                    srcset="<?= esc_url($image['sizes']['mobile']); ?>"
                    media="(max-width: 500px)">
                <source
                    srcset="<?= esc_url($image['url']); ?>">
                <img
                    src="<?= esc_url($image['url']); ?>"
                    loading="lazy"
                    class="fade-in map--image"
                    alt="<?= esc_attr($image['alt']); ?>">
            </picture>
            <div class="locations fade-in in-view">
        <?php else: ?>
            <picture style="display: none;"></picture>
            <div class="locations map-none fade-in in-view">
        <?php endif; ?>
            <h2 class="h5"><?= esc_html(get_field('title')); ?></h2>
            <div class="locations-grid">
                <?php if (!empty($locationBlocks)): ?>
                    <?php foreach ($locationBlocks as $i => $locationBlock):
                    ?>
                        <div class="location-card" style="--n: <?= esc_attr($i); ?>">
                            <h3 class="snug small-title--bold location-card-center">
                                <?= esc_html($locationBlock['title']); ?>
                                <p>
                                    <a href="mailto:<?= esc_html(antispambot($locationBlock['email_address'])); ?>" target="_blank" class="blueprint--button mail--button">Email us <?php get_template_part('parts/svg/right-arrow'); ?></a>
                                </p>
                            </h3>
                            <div class="location-card__content">
                                <p><?= esc_html($locationBlock['description']); ?></p>

                                <?php if (!empty($locationBlock['contact_list'])): ?>
                                    <?php foreach ($locationBlock['contact_list'] as $contact): ?>
                                        <div class="loopnumb">
                                            <div class="phone-numb">
                                                <?php if (!empty($contact['icon'])): ?>
                                                    <img src="<?= esc_url($contact['icon']['url']); ?>" alt="<?= esc_attr($contact['icon']['alt']); ?>" class="icon-size-medium" />
                                                <?php else: ?>
                                                    <img src="" alt="" style="display: none;" />
                                                <?php endif; ?>
                                                <p>
                                                    <a href=""><?= esc_html($contact['number']); ?></a>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>