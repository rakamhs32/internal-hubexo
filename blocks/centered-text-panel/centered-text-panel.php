<?php
$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}
?>
<div class="content-panel yellow-bg centered-text-panel text-center" data-country="<?= esc_attr($countries) ?>">
    <div class="container snug-child fade-in">
        <?= get_field('text');?>
    </div>
</div>