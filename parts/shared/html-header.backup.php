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
                            localStorage.setItem('country_data', JSON.stringify(countryInfo));
                            console.log('Country data saved to local storage:', countryInfo);
                        } catch (e) {
                            console.error('Error saving country data to localStorage:', e);
                        }
                    }
                }
            };

            let currentCountryData = null;
            let currentCountryIso = '';

            try {
                const countryDataStr = localStorage.getItem('country_data');
                if (countryDataStr) {
                    currentCountryData = JSON.parse(countryDataStr);
                    currentCountryIso = currentCountryData.iso_code.toUpperCase();
                }
            } catch (e) {
                console.error('Error retrieving country data:', e);
            }

            // Get the previously detected country (for change detection)
            const previouslyDetectedCountry = localStorage.getItem('previously_detected_country');

            // Check if country has changed
            const hasCountryChanged = previouslyDetectedCountry &&
                previouslyDetectedCountry !== currentCountryIso &&
                currentCountryIso !== '';

            // If country has changed or we've never stored it before, reset redirection state
            if (hasCountryChanged || !previouslyDetectedCountry) {
                if (hasCountryChanged) {
                    console.log(`Country changed from ${previouslyDetectedCountry} to ${currentCountryIso}. Resetting redirection state.`);
                } else if (currentCountryIso) {
                    console.log(`First detection of country: ${currentCountryIso}.`);
                }

                // Store current country as the detected one
                if (currentCountryIso) {
                    localStorage.setItem('previously_detected_country', currentCountryIso);
                }

                // Reset the redirection flag if country changed
                if (hasCountryChanged) {
                    localStorage.removeItem('initial_redirection_complete');
                }
            }

            // Check if we've already performed the initial redirection
            const initialRedirectionComplete = localStorage.getItem('initial_redirection_complete');

            // If we've already done the initial redirection and country hasn't changed, skip redirection logic
            if (initialRedirectionComplete !== 'true') {
                // Only execute this function on first visit or when country changes
                function performInitialRedirection() {
                    // If we don't have a country code, exit
                    if (!currentCountryIso) {
                        console.log('No country data available, no redirection needed');
                        // Mark redirection as complete anyway to prevent future runs
                        localStorage.setItem('initial_redirection_complete', 'true');
                        return;
                    }

                    const targetCountries = ['SE', 'DK', 'FI', 'NO', 'CZ', 'SK', 'PL', 'AT', 'CH', 'AU'];

                    // Special mapping for country-specific URL parameters
                    const countryParamOverrides = {
                        'DK': 'da'
                    };

                    // Function to get the URL country parameter (with fallback to iso_code)
                    function getUrlCountryParam(isoCode) {
                        return countryParamOverrides[isoCode] || isoCode.toLowerCase();
                    }

                    // Check if the user's country is in our target list
                    const isTargetCountry = targetCountries.includes(currentCountryIso);

                    // Only process URL redirection if the user's country is in our target list
                    if (isTargetCountry) {
                        console.log('Processing URL redirection');

                        // Set static main URL
                        const staticMainUrl = 'https://nee.hubexo.com';

                        // Check if we're already on a country-specific path
                        const currentUrl = window.location.href;
                        const currentUrlObj = new URL(currentUrl);
                        const currentPath = currentUrlObj.pathname;

                        // Get the country code segment for the URL
                        const countryCode = getUrlCountryParam(currentCountryIso);

                        // Check if the URL already contains any country code
                        const pathSegments = currentPath.split('/').filter(segment => segment);
                        const hasCountryPath = targetCountries.some(country => {
                            const countryParam = getUrlCountryParam(country);
                            return pathSegments.includes(countryParam);
                        });

                        // Only redirect if we're on the base URL without a country code
                        if (!hasCountryPath) {
                            // Construct the new URL with country code
                            const newUrl = `${staticMainUrl}/${countryCode}${window.location.search}${window.location.hash}`;

                            // Mark that we've completed the initial redirection
                            localStorage.setItem('initial_redirection_complete', 'true');

                            // Redirect to the new URL
                            window.location.href = newUrl;
                            console.log(`Redirecting to URL with country code: ${newUrl}`);

                            // Return early since we're redirecting
                            return;
                        }
                    } else {
                        console.log(`User country ${currentCountryIso} not in target countries list. No redirection needed.`);
                    }

                    // Mark redirection as complete
                    localStorage.setItem('initial_redirection_complete', 'true');
                }

                // Apply the initial redirection logic
                performInitialRedirection();
            } else {
                console.log('Initial redirection already completed, skipping redirect check');
            }

            // Country-specific element filtering (keeps working even after the one-time redirect)
            function applyCountryFiltering() {
                // Skip if no country data available
                if (!currentCountryIso) {
                    return;
                }

                // Get all elements with data-country attribute
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
                        const elementTargetCountries = countriesAttr.split(',').map(c => c.trim().toUpperCase());

                        // Check if user's country is in the target countries
                        isMatch = elementTargetCountries.includes(currentCountryIso);
                    }

                    // Set display property based on matching
                    element.style.display = isMatch ? '' : 'none';

                    // For debugging
                    console.log(`Element: ${element.className}, Countries: ${countriesAttr}, User country: ${currentCountryIso || 'unknown'}, Match: ${isMatch}`);

                    // Add a data attribute to show the element has been processed
                    element.setAttribute('data-country-processed', 'true');
                });
            }

            // Apply the country filtering on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyCountryFiltering);
            } else {
                applyCountryFiltering();
            }

            // Also add country filtering to load event as fallback for any unprocessed elements
            window.addEventListener('load', function () {
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