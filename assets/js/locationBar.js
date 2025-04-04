// Ensure script runs as early as possible
(function () {
    // Console log override for country data storage
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

    // Function to initialize all features
    function initializeFeatures() {
        // Country mappings and configuration
        const countryRegionMap = {
            'AU': 'APAC',
            'NZ': 'APAC',
            'SG': 'APAC',
            'MY': 'APAC',
            'ID': 'APAC',
            'HK': 'APAC',
            'PH': 'APAC',
            'TH': 'APAC',
            'VN': 'APAC',
            'US': 'NA',
            'CA': 'NA',
            'SE': 'NEE',
            'DK': 'NEE',
            'FI': 'NEE',
            'NO': 'NEE',
            'CZ': 'NEE',
            'SK': 'NEE',
            'PL': 'NEE',
            'AT': 'NEE',
            'CH': 'NEE',
            'GB': 'UKI',
            'IE': 'UKI',
            'ES': 'WE',
            'PT': 'WE',
            'DE': 'WE'
        };

        const apacCountries = []; // Added ID and AU to ensure they're included
        const otherRegionCountries = [
            'US', 'CA', 'SE', 'DK', 'FI', 'NO', 'CZ', 'SK', 'PL',
            'GB', 'IE', 'ES', 'PT', 'AT', 'CH', 'DE'
        ];

        const countryIsoMap = {
            'AU': 'Australia',
            'AT': 'Austria',
            'CA': 'Canada',
            'CZ': 'Czech Republic',
            'DK': 'Denmark',
            'FI': 'Finland',
            'DE': 'Germany',
            'HK': 'Hong Kong',
            'ID': 'Indonesia',
            'IE': 'Ireland',
            'MY': 'Malaysia',
            'NZ': 'New Zealand',
            'NO': 'Norway',
            'PH': 'Philippines',
            'PL': 'Poland',
            'PT': 'Portugal',
            'SG': 'Singapore',
            'SK': 'Slovakia',
            'ES': 'Spain',
            'SE': 'Sweden',
            'CH': 'Switzerland',
            'TH': 'Thailand',
            'GB': 'United Kingdom',
            'US': 'USA',
            'VN': 'Vietnam'
        };

        // Handle country data from localStorage
        const countryDataString = localStorage.getItem('country_data');
        let currentCountryCode = '';
        if (countryDataString) {
            try {
                const countryData = JSON.parse(countryDataString);
                currentCountryCode = countryData.iso_code;
                const region = countryRegionMap[currentCountryCode] || '';
                const regionBar = document.getElementById('regionBar');
                const titleElement = document.querySelector('.title-content--bar');

                // Add new option at the top (position 1)
                const selectElement = document.getElementById('OptionCountry');
                if (selectElement && currentCountryCode) {
                    const newOption = document.createElement('option');
                    newOption.value = region;
                    newOption.textContent = countryIsoMap[currentCountryCode] || currentCountryCode;
                    selectElement.insertBefore(newOption, selectElement.firstChild);
                    selectElement.selectedIndex = 0;
                }

                if (titleElement && region) {
                    titleElement.textContent = `You are viewing content for Hubexo Asia Pacific`;
                }

                if (regionBar) {
                    if (apacCountries.includes(currentCountryCode)) {
                        regionBar.classList.add('hidden');
                    } else if (otherRegionCountries.includes(currentCountryCode)) {
                        regionBar.classList.remove('hidden');
                    }
                }
            } catch (e) {
                console.error('Error parsing country data:', e);
            }
        }

        function setupCustomSelect() {
            const customSelects = document.getElementsByClassName("custom-select");
            Array.from(customSelects).forEach(customSelect => {
                // Remove any existing custom select elements to prevent duplication
                const existingElements = customSelect.querySelectorAll('.select-selected, .wrap-card');
                existingElements.forEach(el => el.remove());

                const select = customSelect.getElementsByTagName("select")[0];
                const selectedDiv = document.createElement("DIV");
                selectedDiv.setAttribute("class", "select-selected");
                selectedDiv.textContent = select.options[select.selectedIndex].innerHTML;
                customSelect.appendChild(selectedDiv);

                const wrapCard = document.createElement("DIV");
                wrapCard.setAttribute("class", "wrap-card select-hide");

                // Create global region div
                const globalRegionDiv = document.createElement("DIV");
                globalRegionDiv.setAttribute("class", "global-top--region");
                globalRegionDiv.setAttribute("id", "globalTopRegion");

                const globalIcon = document.createElement("IMG");
                globalIcon.src = `${window.location.origin}/wp-content/themes/hubexo/img/global-icon-region.svg`;

                const globalText = document.createElement("P");
                globalText.textContent = "Global";

                globalRegionDiv.appendChild(globalIcon);
                globalRegionDiv.appendChild(globalText);

                // Global region click event
                globalRegionDiv.addEventListener("click", function (e) {
                    const wrapCardElement = this.parentNode;
                    const selectedElement = wrapCardElement.previousSibling;

                    selectedElement.textContent = "Global";
                    wrapCardElement.classList.add("select-hide");
                    selectedElement.classList.remove("select-arrow-active");
                    select.value = "";

                    const event = new Event('change');
                    select.dispatchEvent(event);
                });

                wrapCard.appendChild(globalRegionDiv);

                const itemsDiv = document.createElement("DIV");
                itemsDiv.setAttribute("class", "select-items select-hide");

                Array.from(select.options).forEach(option => {
                    if (option.hasAttribute('data-icon')) {
                        const optionDiv = document.createElement("DIV");
                        const icon = document.createElement("IMG");
                        icon.src = option.dataset.icon;
                        icon.className = "select-option-icon";

                        optionDiv.appendChild(icon);
                        optionDiv.insertAdjacentText('beforeend', option.innerHTML);

                        optionDiv.addEventListener("click", function (e) {
                            updateSelection(this, select);
                        });
                        itemsDiv.appendChild(optionDiv);
                    }
                });

                wrapCard.appendChild(itemsDiv);
                customSelect.appendChild(wrapCard);

                selectedDiv.addEventListener("click", function (e) {
                    e.stopPropagation();
                    closeAllSelect(this);

                    const wrapCardElement = this.nextSibling;
                    if (wrapCardElement) {
                        wrapCardElement.classList.toggle("select-hide");
                    }

                    const selectItems = this.nextSibling.querySelector('.select-items');
                    if (selectItems) {
                        selectItems.classList.toggle("select-hide");
                        this.classList.toggle("select-arrow-active");
                    }
                });
            });
        }


        function updateSelection(clickedOption, select) {
            const customSelect = select.closest('.custom-select');
            if (!customSelect) return;

            const selected = customSelect.querySelector('.select-selected');
            if (!selected) return;

            Array.from(select.options).forEach((option, index) => {
                if (option.innerHTML === clickedOption.textContent) {
                    select.selectedIndex = index;
                    selected.textContent = option.innerHTML;

                    const sameAsSelected = clickedOption.parentNode.getElementsByClassName("same-as-selected");
                    Array.from(sameAsSelected).forEach(element => {
                        element.removeAttribute("class");
                    });
                    clickedOption.setAttribute("class", "same-as-selected");
                }
            });

            selected.click();
        }


        function closeAllSelect(elmnt) {
            const selectItems = document.getElementsByClassName("select-items");
            const selectSelected = document.getElementsByClassName("select-selected");
            const wrapCards = document.getElementsByClassName("wrap-card");
            const globalRegions = document.getElementsByClassName("global-top--region");
            const arrNo = [];

            Array.from(selectSelected).forEach((item, index) => {
                if (elmnt === item) {
                    arrNo.push(index);
                } else {
                    item.classList.remove("select-arrow-active");
                }
            });

            // Handle select items
            Array.from(selectItems).forEach((item, index) => {
                if (!arrNo.includes(index)) {
                    item.classList.add("select-hide");
                }
            });

            // Handle wrap cards (which contain global-top--region)
            Array.from(wrapCards).forEach((item, index) => {
                if (!arrNo.includes(index)) {
                    item.classList.add("select-hide");
                }
            });

            // Handle global regions specifically
            Array.from(globalRegions).forEach(region => {
                const parentWrapCard = region.closest('.wrap-card');
                if (parentWrapCard && !arrNo.includes(Array.from(wrapCards).indexOf(parentWrapCard))) {
                    parentWrapCard.classList.add("select-hide");
                }
            });
        }

        // Helper function to get country code from the country name
        function getCountryCodeFromSelection(countryName) {
            // Reverse lookup in the countryIsoMap
            for (const [code, name] of Object.entries(countryIsoMap)) {
                if (name === countryName) {
                    return code;
                }
            }
            return null;
        }

        // Helper function to update localStorage with new country code
        function updateLocalStorageCountry(newCountryCode) {
            try {
                // Get the existing country data from localStorage
                const countryDataString = localStorage.getItem('country_data');
                if (countryDataString) {
                    const countryData = JSON.parse(countryDataString);

                    // Update the country code
                    countryData.iso_code = newCountryCode;

                    // If the names field exists, try to update it with the proper country name
                    if (countryData.names && countryIsoMap[newCountryCode]) {
                        countryData.names.en = countryIsoMap[newCountryCode];
                    }

                    // Save updated data back to localStorage
                    localStorage.setItem('country_data', JSON.stringify(countryData));
                    console.log('Country data updated in local storage:', countryData);
                }
            } catch (e) {
                console.error('Error updating country data in localStorage:', e);
            }
        }

        // Setup Custom Select
        setupCustomSelect();
        document.addEventListener("click", closeAllSelect);

        // Regional Redirect Setup
        const form = document.querySelector('.button-container');
        const select = form.querySelector('select');
        const continueButton = form.querySelector('.submit-button');

        function redirectToRegionalSite(event) {
            event.preventDefault();
            const selectedOption = select.options[select.selectedIndex];
            const mainDomain = 'hubexo.com';

            if (selectedOption && selectedOption.value) {
                const region = selectedOption.value;

                // Check if we need to handle APAC special case
                if (region === 'APAC') {
                    // Check if we're already in APAC region
                    const currentRegion = countryRegionMap[currentCountryCode];
                    if (currentRegion === 'APAC') {
                        // We're already in APAC, get selected country
                        const selectedCountryName = selectedOption.textContent;
                        const selectedCountryCode = getCountryCodeFromSelection(selectedCountryName);

                        if (selectedCountryCode && selectedCountryCode !== currentCountryCode) {
                            // Update localStorage with new country code
                            updateLocalStorageCountry(selectedCountryCode);

                            // Reload the page instead of redirecting
                            console.log(`Switching APAC country from ${currentCountryCode} to ${selectedCountryCode}`);
                            window.location.reload();
                            return;
                        }
                    }
                }

                // Default behavior for non-APAC or when not already in APAC
                window.location.href = `https://${region.toLowerCase()}.${mainDomain}`;
            } else {
                window.location.href = `https://${mainDomain}`;
            }
        }

        form.addEventListener('submit', redirectToRegionalSite);
        continueButton.addEventListener('click', redirectToRegionalSite);

        // Close Button Setup
        function setupCloseBarButton(button, element) {
            if (!button || !element) return;

            button.addEventListener('click', function () {
                element.classList.add('close-bar');
                element.style.display = 'none';

                const heroBanner = document.querySelector('.hero-banner.plum-bg.header-pad-two');
                const locationBtn = document.getElementById('locationBtn');
                const homepageBanner = document.querySelector('.homepage-banner');
                const headerPad = document.querySelector('.header-pad-two');

                if (heroBanner) heroBanner.classList.add('shorted');
                if (locationBtn) locationBtn.classList.add('active');
                if (homepageBanner) homepageBanner.classList.add('shorted');
                if (headerPad) headerPad.classList.add('shorted');

            });
        }

        const regionBar = document.getElementById('regionBar');
        const closeBarButton = document.getElementById('CloseBarButton');
        const closeBarButtonMobile = document.getElementById('CloseBarButtonMobile');
        const locationBtn = document.getElementById('locationBtn');

        if (locationBtn && regionBar) {
            locationBtn.addEventListener('click', function () {
                regionBar.style.display = 'block';
                regionBar.style.opacity = '1';
                locationBtn.classList.remove('active');
            });
        }

        setupCloseBarButton(closeBarButton, regionBar);
        setupCloseBarButton(closeBarButtonMobile, regionBar);
    }

    // Multiple methods to ensure early execution
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeFeatures);
    } else if (document.readyState === 'interactive') {
        setTimeout(initializeFeatures, 0);
    } else {
        initializeFeatures();
    }

    // Additional fallback to ensure script runs
    window.addEventListener('load', initializeFeatures);
})();