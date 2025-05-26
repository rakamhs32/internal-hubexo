

<?php
    $selectCountry = get_field('select_country'); // Get the selected countries as an array
    if ($selectCountry && is_array($selectCountry)) {
        $countries = implode(',', $selectCountry);
    } else {
        $countries = '';
    }
?>
implode

<div class="content-panel no-bg" data-country="<?= esc_attr($countries) ?>">
    <div class="container">
        <div class="title-block">
            <h2 class="h5"></h2>
        </div>
        <div class="gallery-content fade-in">
            <div class="gallery-lists">
                <div class="gallery-item">

                </div>
            </div>
        </div>
    </div>
</div>