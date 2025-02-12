<div class="content-panel three-column earth-bg" <?= getBlockId($block) ?>>
    <div class="container snug-child text-block fade-in">
        <h2><?= get_field('title'); ?></h2>
        <div class="three-column--grid">
            <div class="three-column--column snug-child">
                <?= get_field('column_one'); ?>
            </div>
            <div class="three-column--column snug-child">
                <?= get_field('column_two'); ?>
            </div>
            <div class="three-column--column snug-child">
                <?= get_field('column_three'); ?>
            </div>
        </div>
    </div>
</div>