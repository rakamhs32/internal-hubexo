<!DOCTYPE HTML>
<!--[if IEMobile 7 ]>
<html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]>
<html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <title><?php wp_title( '|' ); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
    <meta name="format-detection" content="telephone=no">
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/safari-pinned-tab.svg"
          color="#321432">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <script>
        window.THEME_DIRECORY = "<?= get_stylesheet_directory_uri(); ?>";
        window.GOOGLE_MAPS_API_KEY = "<?= GOOGLE_MAPS_API_KEY ?>";
    </script>
    <link rel="stylesheet" href="<?php echo get_theme_file_uri( 'node_modules/swiper/swiper-bundle.min.css' ) ?>">
    <script src="<?php echo get_theme_file_uri( 'node_modules/swiper/swiper-bundle.min.js' ) ?>"></script>
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
        (function () {
            // Function to execute as early as possible
            function initializeCountryTargeting() {
                // Check if we've already processed URL redirection in this session
                const urlRedirectionProcessed = sessionStorage.getItem('url_redirection_processed');

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
                    // Apply country filtering anyway to show all content
                    applyCountryFiltering('');
                    return;
                }

                // Convert user country to uppercase for case-insensitive comparison
                const upperUserCountry = userCountry.toUpperCase();

                const targetCountries = ['SE', 'DK', 'FI', 'NO', 'CZ', 'SK', 'PL', 'AT', 'CH'];

                // Special mapping for country-specific URL parameters
                const countryParamOverrides = {
                    'DK': 'da'
                };

                // Function to get the URL country parameter (with fallback to iso_code)
                function getUrlCountryParam(isoCode) {
                    return countryParamOverrides[isoCode] || isoCode.toLowerCase();
                }


                // Check if the user's country is in our target list
                const isTargetCountry = targetCountries.includes(upperUserCountry);

                // Only process URL redirection if:
                // 1. We haven't processed it in this session yet (first visit)
                // 2. The user's country is in our target list
                if (!urlRedirectionProcessed && isTargetCountry) {
                    console.log('First visit in this session, processing URL redirection');

                    // Set static main URL
                    const staticMainUrl = 'http://54.252.222.112';

                    // Parse the static URL to separate base and path
                    const staticUrlObj = new URL(staticMainUrl);
                    const staticBasePath = staticUrlObj.pathname; // This will be '/hubexo'

                    // Check if current URL matches our static base URL pattern
                    const currentUrl = window.location.href;
                    const currentUrlObj = new URL(currentUrl);

                    // Get the expected path with country code (use mapping function here)
                    const countryCode = getUrlCountryParam(upperUserCountry);
                    const expectedCountryPath = `${staticBasePath}/${countryCode}`;

                    // Check if the URL already has the country code in the correct position
                    if (!currentUrlObj.pathname.startsWith(expectedCountryPath)) {
                        // Construct the new URL with country code in the correct position
                        const newUrl = `${staticMainUrl}/${countryCode}${window.location.search}${window.location.hash}`;

                        // Mark that we've processed the URL redirection for this session
                        sessionStorage.setItem('url_redirection_processed', 'true');

                        // Redirect to the new URL
                        window.location.href = newUrl;
                        console.log(`Redirecting to URL with country code: ${newUrl}`);

                        // Return early since we're redirecting
                        return;
                    }
                }

                else if (urlRedirectionProcessed) {
                    console.log('URL redirection already processed in this session, skipping');
                } else if (!isTargetCountry) {
                    console.log(`User country ${userCountry} not in target countries list. No URL modification needed.`);
                }

                // Mark that we've processed the URL redirection for this session
                // (even if we didn't actually redirect)
                sessionStorage.setItem('url_redirection_processed', 'true');

                // Always apply country filtering to elements
                applyCountryFiltering(upperUserCountry);

                // Function to apply country-based filtering to elements
                function applyCountryFiltering(currentUpperUserCountry) {
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
                            // If we have a country code, check for matches
                            if (currentUpperUserCountry) {
                                // Clean and normalize the country codes (trim spaces, uppercase)
                                const elementTargetCountries = countriesAttr.split(',').map(c => c.trim().toUpperCase());

                                // Check if user's country is in the target countries
                                isMatch = elementTargetCountries.includes(currentUpperUserCountry);
                            } else {
                                // No country code, show everything
                                isMatch = true;
                            }
                        }

                        // Set display property based on matching
                        element.style.display = isMatch ? '' : 'none';

                        // For debugging
                        console.log(`Element: ${element.className}, Countries: ${countriesAttr}, User country: ${currentUpperUserCountry || 'unknown'}, Match: ${isMatch}`);

                        // Add a data attribute to show the element has been processed
                        element.setAttribute('data-country-processed', 'true');
                    });

                    // Save a flag in sessionStorage to indicate we've processed the page filtering
                    sessionStorage.setItem('country_elements_processed', 'true');
                }
            }

            // Check if DOM is already loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeCountryTargeting);
            } else {
                // If DOM is already loaded, apply immediately
                initializeCountryTargeting();
            }

            // Also add to load event as fallback
            window.addEventListener('load', function () {
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