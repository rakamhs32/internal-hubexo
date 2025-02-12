<?php
$title = get_field('title');
$jobs = get_field('jobs');

?>

<div class="content-panel jobs aluminium-bg" <?= getBlockId($block) ?>>
    <div class="container snug-child">
        <h2 class="h5"><?= $title; ?></h2>
        <?php if (!empty($jobs)): ?>
            <div class="jobs-grid">
                <?php foreach ($jobs as $i => $job):
                    $link = $job['link'];
                    if (!empty($link)) {
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    }
                ?>
                    <div class="job-card" style="--n: <?= $i ?>">
                        <h3 class="snug small-title--bold">
                            <?= $job['title']; ?>
                            <?php get_template_part('parts/svg/jobs'); ?>
                        </h3>
                        <?php if (!empty($link)): ?>
                            <p><a href="<?= $link['url']; ?>" target="<?= esc_attr($link_target); ?>" class="blueprint--button"><?= $link['title']; ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>