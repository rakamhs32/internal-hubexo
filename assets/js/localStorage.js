// Enhanced country targeting script - add to head section for early execution
(function () {
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
    window.addEventListener('load', function () {
        // Check if we need to reprocess (only process unprocessed elements)
        const unprocessedElements = document.querySelectorAll('[data-country]:not([data-country-processed])');
        if (unprocessedElements.length > 0) {
            initializeCountryTargeting();
        }
    });
})();