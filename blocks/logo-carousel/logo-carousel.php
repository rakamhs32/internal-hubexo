<?php

$title = get_field('title');
$logos = get_field('logos');
$showRegions = get_field('show_regions');
?>

<div class="content-panel half-space logo-carousel white-bg fade-in">
    <div class="container">
        <h2 class="h5 snug <?= the_field('center_title'); ?>"><?= $title; ?></h2>
    </div>
    <?php if (!empty($logos)): ?>
        <div class="splide logo-slider <?php if (!empty($showRegions)): ?>has-titles<?php endif; ?>" id="logo-carousel">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <?php foreach ($logos as $logo):
                            $region = get_field('region', $logo['ID']);
                            $url = get_field('url', $logo['ID']);
                            $image = "<img src=\"" . $logo['sizes']['mobile'] . "\" alt=\"" . $logo['alt'] . "\" style=\"aspect-ratio: {$logo['width']}/{$logo['height']}\" />";
                        ?>
                            <li class="splide__slide <?php if (!empty($showRegions) && !empty($region)): ?>has-title<?php endif; ?>">
                                <?php if (!empty($showRegions) && !empty($region)): ?>
                                    <span class="logo-title"><?= $region; ?></span>
                                <?php elseif (!empty($showRegions)): ?>
                                    <span class="logo-title">&nbsp;</span>
                                <?php endif; ?>
                                <?php if ($url && ! empty($url)): ?>
                                    <a href="<?= $url ?>" target="_blank">
                                        <?= $image ?>
                                    </a>
                                <?php else: ?>
                                    <?= $image ?>
                                <?php endif; ?>

                            </li>
                        <?php endforeach; ?>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>