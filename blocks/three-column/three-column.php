<?php
$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}
?>

<div class="content-panel three-column earth-bg" <?= getBlockId($block) ?> data-country="<?= esc_attr($countries) ?>">
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