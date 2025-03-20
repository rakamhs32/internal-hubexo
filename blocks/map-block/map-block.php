<?php
$titleMap = get_field('title_map'); // Get the title for the map
$shortCodeMap = get_field('short_code_map'); // Get the shortcode for the map

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry); // Convert the array to a comma-separated string
} else {
    $countries = ''; // Default to an empty string if no countries are selected
}
?>

<div class="content-panel earth-bg map" data-country="<?= esc_attr($countries) ?>">
    <div class="container">
        <div class="title-block">
            <?php if (!empty($titleMap)): ?>
                <h2 class="h5"><?= esc_html($titleMap); ?></h2>
            <?php endif; ?>
        </div>
        <div class="fade-in">
            <div class="map-shortcode">
                <?php
                if (!empty($shortCodeMap)) {
                    echo do_shortcode($shortCodeMap); // Process and display the shortcode
                } else {
                    echo '<p>No map available.</p>'; // Fallback message if shortcode is empty
                }
                ?>
            </div>
        </div>
    </div>
</div>
