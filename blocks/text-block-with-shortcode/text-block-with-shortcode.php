<?php
$content              = get_field( 'content' );
$gravityFormShortcode = get_field( 'gravity_form_shortcode' );
$hubspotShortcode     = get_field( 'hubspot_shortcode' );
$position             = get_field( 'position' );
$background           = get_field( 'background_color' );

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
	$countries = implode( ',', $selectCountry );
} else {
	$countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<div class="content-panel text-block white-text <?= $background ?> <?= $BlockCss; ?>"
     data-country="<?= esc_attr( $countries ) ?>"
     id="<?= $BlockId; ?>">
    <div class="container fade-in">
        <div class="text-block--text snug-child text-block-with--shortcode <?= $position ?>">
            <div class="text-content">
				<?= $content ?>
            </div>
            <div class="block-shortcode">
				<?php
				if ( ! empty( $gravityFormShortcode ) ) {
					echo do_shortcode( $gravityFormShortcode );
				} elseif ( ! empty( $hubspotShortcode ) ) {
					// Output the script
					echo '<div class="shortCodeBlock">' . $hubspotShortcode . '</div>';

					// Add JavaScript to modify the form after it loads
					?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // HubSpot forms might load asynchronously, so we need to use a MutationObserver
                            const observer = new MutationObserver(function (mutations) {
                                const hsForm = document.querySelector('.hs-form');
                                if (hsForm) {
                                    // Form is loaded, make your modifications
                                    hsForm.classList.add('my-custom-class');

                                    // Optional: Add custom styling or behaviors
                                    const inputs = hsForm.querySelectorAll('input');
                                    inputs.forEach(input => {
                                        input.classList.add('custom-input-class');
                                    });

                                    // Stop observing once we've found the form
                                    observer.disconnect();
                                }
                            });

                            // Start observing the document body for changes
                            observer.observe(document.body, {childList: true, subtree: true});
                        });
                    </script>
					<?php
				}
				?>
            </div>
        </div>
    </div>
</div>