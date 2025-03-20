<?php

$title = get_field('title');
$description = get_field('description');

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}
?>

<div class="title-banner header-pad-two" data-country="<?= esc_attr($countries) ?>">
    <div class="container snug-child fade-up">
        <h1 class="h2">
            <?php if (!empty($title)): ?>
                <?= $title; ?>
            <?php else: ?>
                <?= the_title(); ?>
            <?php endif; ?>

        </h1>
        <?php if (!empty($description)): ?>
            <div class="desc-subtitle">
                <?= $description; ?>
            </div>
            <?php else: ?>
            <div class="desc-subtitle" style="display: none">
            </div>
            <?php endif; ?>

    </div>
</div>