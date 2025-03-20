<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
	<title><?php wp_title('|'); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	<meta name="format-detection" content="telephone=no">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/safari-pinned-tab.svg" color="#321432">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	<script>
		window.THEME_DIRECORY = "<?= get_stylesheet_directory_uri(); ?>";
		window.GOOGLE_MAPS_API_KEY = "<?= GOOGLE_MAPS_API_KEY ?>";
	</script>
	<link rel="stylesheet" href="<?php echo get_theme_file_uri('node_modules/swiper/swiper-bundle.min.css')?>">
	<script src="<?php echo get_theme_file_uri('node_modules/swiper/swiper-bundle.min.js')?>"></script>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-V49ZSF18RF"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'G-V49ZSF18RF');
	</script>

<script>
    // Enhanced country targeting script - add to head section for early execution
    (function() {
        // Function to execute as early as possible
        function initializeCountryTargeting() {
            // Try to get country from localStorage
            let userCountry = '';
            try {
                const countryData = localStorage.getItem('country_data');
                if (countryData) {
                    const parsedData = JSON.parse(countryData);
                    userCountry = parsedData.iso_code;

                    // Save to sessionStorage for quicker access on subsequent page views
                    sessionStorage.setItem('user_country', userCountry);
                } else {
                    // Try to get from sessionStorage if not in localStorage
                    userCountry = sessionStorage.getItem('user_country') || '';
                }
            } catch (e) {
                console.error('Error retrieving country data:', e);
            }

            // If we don't have a country code, show everything and exit
            if (!userCountry) {
                console.log('No country data available, showing all content');
                return;
            }

            // Apply country filtering to elements
            function applyCountryFiltering() {
                // Get all elements with data-country attribute, including empty ones
                const countryElements = document.querySelectorAll('[data-country]');

                countryElements.forEach(element => {
                    const countriesAttr = element.getAttribute('data-country');
                    // Default match status
                    let isMatch = false;

                    // Check if the attribute is empty or not
                    if (!countriesAttr || countriesAttr.trim() === '') {
                        // Empty data-country means show to everyone
                        isMatch = true;
                    } else {
                        // Clean and normalize the country codes (trim spaces, uppercase)
                        const targetCountries = countriesAttr.split(',').map(c => c.trim().toUpperCase());

                        // Check if user's country is in the target countries
                        isMatch = targetCountries.includes(userCountry.toUpperCase());
                    }

                    // Set display property based on matching
                    element.style.display = isMatch ? '' : 'none';

                    // For debugging
                    console.log(`Element: ${element.className}, Countries: ${countriesAttr}, User country: ${userCountry}, Match: ${isMatch}`);

                    // Add a data attribute to show the element has been processed
                    element.setAttribute('data-country-processed', 'true');
                });

                // Save a flag in sessionStorage to indicate we've processed the page
                sessionStorage.setItem('country_elements_processed', 'true');
            }

            // Check if DOM is already loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyCountryFiltering);
            } else {
                // If DOM is already loaded, apply immediately
                applyCountryFiltering();
            }
        }

        // Run immediately for fastest execution
        initializeCountryTargeting();

        // Also add to load event as fallback
        window.addEventListener('load', function() {
            // Check if we need to reprocess (only process unprocessed elements)
            const unprocessedElements = document.querySelectorAll('[data-country]:not([data-country-processed])');
            if (unprocessedElements.length > 0) {
                initializeCountryTargeting();
            }
        });
    })();
</script>

	
</head>

<body <?php body_class(); ?>>
	<div style="display: none">
		<svg id="master-pattern-a">
			<g id="master-pattern-a-group"></g>
		</svg>
	</div>