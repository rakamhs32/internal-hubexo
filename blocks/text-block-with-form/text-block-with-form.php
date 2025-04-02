<?php
$image = get_field('image');
$gravity_form = get_field('gravity_form');
$hubspot_embed = get_field('hubspot_embed');
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

<div class="content-panel text-block white-text plum-bg" data-country="<?= esc_attr($countries) ?>">
    <div class="container fade-in">
        <div class="text-block--text snug-child text-block-with--image">
            <div class="text-content">
                <?= get_field('text'); ?>
                <?php if (!empty($link)): ?>
                    <div><a href="<?= $link['url']; ?>" target="<?= esc_attr($link_target); ?>" class="blueprint--button"><?= $link['title']; ?> <?php get_template_part('parts/svg/right-arrow'); ?></a></div>
                <?php endif; ?>
            </div>
            <div class="image-content">
                <?php if (!empty($gravity_form)): ?>
                    <div>
                        <?php echo do_shortcode($gravity_form); ?>
                    </div>
                <?php else: ?>
                    <div style="display: none;"></div>
                <?php endif; ?>

                <?php if (!empty($hubspot_embed)): ?>

                                                        <?= $hubspot_embed ?>

                                                <?php else: ?>
                                                    <div style="display: none;"></div>
                                                <?php endif; ?>
            </div>
        </div>
    </div>
</div>