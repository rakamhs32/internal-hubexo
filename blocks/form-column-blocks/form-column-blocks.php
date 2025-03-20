<?php

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}

?>

<div class="container" data-country="<?= esc_attr($countries) ?>">
    <div class="form-and-content">
    </div>
</div>