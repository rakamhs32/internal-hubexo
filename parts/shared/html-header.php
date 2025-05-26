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
        (function () {
            const originalConsoleLog = console.log;
            console.log = function (...args) {
                originalConsoleLog.apply(console, args);
                if (args.length > 0 && typeof args[0] === 'object') {
                    const data = args[0];
                    if (data.geo && data.geo.country && data.geo.country.data) {
                        const countryData = data.geo.country.data;
                        const countryInfo = {
                            iso_code: countryData.iso_code,
                            names: countryData.names
                        };
                        try {
                            // Store in our format
                            localStorage.setItem('country_data', JSON.stringify(countryInfo));

                            // Also update the other storage keys for consistency
                            localStorage.setItem('previously_detected_country', countryInfo.iso_code);
                            localStorage.setItem('user_country', countryInfo.iso_code);

                            console.log('Country data saved to local storage:', countryInfo);
                        } catch (e) {
                            console.error('Error saving country data to localStorage:', e);
                        }
                    }
                }
            };
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if redirection has already been performed in this session
            const redirectionPerformed = sessionStorage.getItem('redirection_performed');

            // If redirection was already done in this session, don't proceed
            if (redirectionPerformed === 'true') {
                return;
            }

            // List of countries to check against
            // const validApacCountries = ['AU', 'NZ', 'SG', 'MY', 'ID', 'HK', 'PH', 'TH', 'VN'];
            // const validNaCountries = ['US', 'CA'];
            // const validNeeCountries = ['SE', 'DA', 'FI', 'NO', 'CZ', 'SK', 'PL', 'AT', 'CH'];
            // const validUkiCountries = ['GB', 'IE'];
            const validWeCountries = ['ES', 'PT', 'DE'];

            // Country to language/path mapping
            const countryOverrides = {
                'ES': 'es',  // Denmark maps to Danish language code
                // Add more overrides as needed
            };

            // Check if the URL already contains a valid language code in the path
            const currentUrl = window.location.href;
            const urlObj = new URL(currentUrl);
            const pathParts = urlObj.pathname.split('/').filter(Boolean);
            const firstPathPart = pathParts[0] ? pathParts[0].toLowerCase() : '';

            // Get all the possible path values we'd redirect to (country codes or language overrides)
            const allPossiblePaths = [...validWeCountries.map(c => c.toLowerCase()),
                ...Object.values(countryOverrides)];

            // If user has already navigated to a valid path, don't override it
            if (firstPathPart && allPossiblePaths.includes(firstPathPart)) {
                // Save this path selection to storage
                // We need to reverse lookup - if it's a language code from our override map,
                // we need to find the country that corresponds to it
                let selectedCountry = firstPathPart.toUpperCase();

                // Check if this is a language code from our overrides
                const countryFromLang = Object.entries(countryOverrides)
                    .find(([country, lang]) => lang === firstPathPart);

                if (countryFromLang) {
                    selectedCountry = countryFromLang[0]; // Use the country code
                }

                // Only proceed if it's a valid country (either direct or from override)
                if (validWeCountries.includes(selectedCountry)) {
                    try {
                        localStorage.setItem('previously_detected_country', selectedCountry);
                        localStorage.setItem('user_country', selectedCountry);

                        // Update country_data with consistent information if possible
                        const countryDataStr = localStorage.getItem('country_data');
                        if (countryDataStr) {
                            const countryData = JSON.parse(countryDataStr);
                            countryData.iso_code = selectedCountry;
                            localStorage.setItem('country_data', JSON.stringify(countryData));
                        }
                    } catch (e) {
                        console.error('Error updating country storage:', e);
                    }
                }

                sessionStorage.setItem('redirection_performed', 'true');
                return;
            }

            // Try to determine the country from available sources
            try {
                let countryCode = null;

                // First check country_data (our primary source)
                const countryDataStr = localStorage.getItem('country_data');
                if (countryDataStr) {
                    const countryData = JSON.parse(countryDataStr);
                    if (countryData && countryData.iso_code && validWeCountries.includes(countryData.iso_code)) {
                        countryCode = countryData.iso_code;
                    }
                }

                // If not found, check the other storage keys
                if (!countryCode) {
                    const userCountry = localStorage.getItem('user_country');
                    if (userCountry && validWeCountries.includes(userCountry)) {
                        countryCode = userCountry;
                    } else {
                        const prevDetectedCountry = localStorage.getItem('previously_detected_country');
                        if (prevDetectedCountry && validWeCountries.includes(prevDetectedCountry)) {
                            countryCode = prevDetectedCountry;
                        }
                    }
                }

                // If we found a valid country, redirect
                if (countryCode) {
                    // Check if we have an override for this country
                    let pathCode = countryCode.toLowerCase();
                    if (countryOverrides[countryCode]) {
                        pathCode = countryOverrides[countryCode];
                    }

                    // Create the new URL with the appropriate code
                    const newUrl = urlObj.origin + '/' + pathCode + '/';

                    // Mark that redirection has been performed for this session
                    sessionStorage.setItem('redirection_performed', 'true');

                    // Only redirect if we're on the homepage or a non-specific page
                    if (urlObj.pathname === '/' || !allPossiblePaths.includes(firstPathPart)) {
                        // Mark that URL redirection has been processed
                        localStorage.setItem('url_redirection_processed', 'true');

                        window.location.href = newUrl;
                    }
                } else {
                    // No valid country found, mark as processed anyway
                    sessionStorage.setItem('redirection_performed', 'true');
                }
            } catch (e) {
                console.error('Error processing country data:', e);
                // Mark as processed even on error to prevent repeated error attempts
                sessionStorage.setItem('redirection_performed', 'true');
            }
        });
    </script>

    <script>
        // Simplified country filtering script
        (function () {
            // The main function - only keeping country filtering functionality
            function applyCountryFiltering() {
                // Try to get country from storage
                let userCountry = '';
                try {
                    const countryData = localStorage.getItem('country_data');
                    if (countryData) {
                        const parsedData = JSON.parse(countryData);
                        userCountry = parsedData.iso_code.toUpperCase();
                    } else {
                        // Try to get from sessionStorage if not in localStorage
                        userCountry = (sessionStorage.getItem('user_country') || '').toUpperCase();
                    }
                } catch (e) {
                    console.error('Error retrieving country data:', e);
                }

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
                        if (userCountry) {
                            // Clean and normalize the country codes (trim spaces, uppercase)
                            const elementTargetCountries = countriesAttr.split(',').map(c => c.trim().toUpperCase());

                            // Check if user's country is in the target countries
                            isMatch = elementTargetCountries.includes(userCountry);
                        } else {
                            // No country code, show everything
                            isMatch = true;
                        }
                    }

                    // Set display property based on matching
                    element.style.display = isMatch ? '' : 'none';

                    // For debugging
                    console.log(`Element: ${element.className}, Countries: ${countriesAttr}, User country: ${userCountry || 'unknown'}, Match: ${isMatch}`);

                    // Add a data attribute to show the element has been processed
                    element.setAttribute('data-country-processed', 'true');
                });
            }

            // Check if DOM is already loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyCountryFiltering);
            } else {
                // If DOM is already loaded, apply immediately
                applyCountryFiltering();
            }

            // Also add to load event as fallback
            window.addEventListener('load', function () {
                // Check if we need to reprocess (only process unprocessed elements)
                const unprocessedElements = document.querySelectorAll('[data-country]:not([data-country-processed])');
                if (unprocessedElements.length > 0) {
                    applyCountryFiltering();
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