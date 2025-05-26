export default {
    // Store handler references at the module level
    handlers: {
        closeAllSelect: null,
        redirectToRegionalSite: null,
        locationBtnClick: null
    },

    init() {
        // Override console.log for country data storage
        this.setupConsoleLogOverride();

        // Initialize all features
        this.initializeFeatures();
    },

    setupConsoleLogOverride() {
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
    },

    initializeFeatures() {
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

        const apacCountries = ['SG', 'MY', 'HK', 'PH', 'TH', 'VN', 'ID', 'AU'];
        const otherRegionCountries = [
            'US', 'CA', 'SE', 'DK', 'FI', 'NO', 'CZ', 'SK', 'PL',
            'GB', 'IE', 'ES', 'PT', 'AT', 'CH', 'DE', 'NZ', 'SG',
            'MY', 'HK', 'PH', 'TH', 'VN', 'ID', 'AU'
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
        this.handleCountryData(countryRegionMap, countryIsoMap, apacCountries, otherRegionCountries);

        // Setup Custom Select
        this.setupCustomSelect();

        // Setup Regional Redirect
        this.setupRegionalRedirect(countryIsoMap);

        // Setup Close Bar Button
        this.setupCloseBarButtons();
    },

    handleCountryData(countryRegionMap, countryIsoMap, apacCountries, otherRegionCountries) {
        const countryDataString = localStorage.getItem('country_data');

        if (countryDataString) {
            try {
                const countryData = JSON.parse(countryDataString);
                const countryCode = countryData.iso_code;
                const region = countryRegionMap[countryCode] || '';
                const regionBar = document.getElementById('regionBar');
                const titleElement = document.querySelector('.title-content--bar');

                // Add new option at the top (position 1)
                const selectElement = document.getElementById('OptionCountry');
                if (selectElement && countryCode) {
                    const newOption = document.createElement('option');
                    newOption.value = region;
                    newOption.textContent = countryIsoMap[countryCode] || countryCode;
                    selectElement.insertBefore(newOption, selectElement.firstChild);
                    selectElement.selectedIndex = 0;
                }

                if (titleElement && region) {
                    titleElement.textContent = `You are viewing content for Hubexo Asia Pacific`;
                }

                // if (regionBar) {
                //     if (apacCountries.includes(countryCode)) {
                //         regionBar.classList.add('hidden');
                //     } else if (otherRegionCountries.includes(countryCode)) {
                //         regionBar.classList.remove('hidden');
                //     }
                // }
            } catch (e) {
                console.error('Error parsing country data:', e);
            }
        }
    },

    setupCustomSelect() {
        const customSelects = document.getElementsByClassName("custom-select");

        // Store the handler reference for later removal
        this.handlers.closeAllSelect = this.closeAllSelect.bind(this);

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
            const module = this; // Preserve the module's `this` for inner functions
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
                        module.updateSelection(this, select);
                    });
                    itemsDiv.appendChild(optionDiv);
                }
            });

            wrapCard.appendChild(itemsDiv);
            customSelect.appendChild(wrapCard);

            selectedDiv.addEventListener("click", function (e) {
                e.stopPropagation();
                module.handlers.closeAllSelect(this);

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

        // Use the stored reference
        document.addEventListener("click", this.handlers.closeAllSelect);
    },

    updateSelection(clickedOption, select) {
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
    },

    closeAllSelect(elmnt) {
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
    },

    setupRegionalRedirect(countryIsoMap) {
        const form = document.querySelector('.button-container');
        if (!form) return;

        const select = form.querySelector('select');
        const continueButton = form.querySelector('.submit-button');

        if (!select || !continueButton) return;

        // Store the handler reference
        this.handlers.redirectToRegionalSite = (event) => {
            event.preventDefault();
            const selectedOption = select.options[select.selectedIndex];
            const mainDomain = 'hubexo.com';

            if (selectedOption && selectedOption.value) {
                const region = selectedOption.value;
                const selectedOptionText = selectedOption.textContent.trim();

                // Find the ISO code that corresponds to the selected country name
                let selectedIsoCode = '';
                for (const [code, name] of Object.entries(countryIsoMap)) {
                    if (name === selectedOptionText) {
                        selectedIsoCode = code;
                        break;
                    }
                }

                // If we found a matching ISO code, update the localStorage
                if (selectedIsoCode) {
                    // Create country data object
                    const countryInfo = {
                        iso_code: selectedIsoCode,
                        names: {
                            en: selectedOptionText
                        }
                    };

                    // Save to localStorage
                    try {
                        localStorage.setItem('country_data', JSON.stringify(countryInfo));
                        console.log('Country data updated in local storage:', countryInfo);
                    } catch (e) {
                        console.error('Error saving country data to localStorage:', e);
                    }

                    // Check if this is an APAC country
                    const apacCountries = ['AU', 'NZ', 'SG', 'MY', 'ID', 'HK', 'PH', 'TH', 'VN'];

                    if (region === 'APAC' || apacCountries.includes(selectedIsoCode)) {
                        // For APAC countries, just reload the current page
                        location.reload();
                        return; // Exit the function to prevent further execution
                    }
                }

                // For non-APAC countries, redirect to the regional subdomain
                window.location.href = `https://${region.toLowerCase()}.${mainDomain}`;
            } else {
                window.location.href = `https://${mainDomain}`;
            }
        };

        form.addEventListener('submit', this.handlers.redirectToRegionalSite);
        continueButton.addEventListener('click', this.handlers.redirectToRegionalSite);
    },

    setupCloseBarButton(button, element) {
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
    },

    setupCloseBarButtons() {
        const regionBar = document.getElementById('regionBar');
        const closeBarButton = document.getElementById('CloseBarButton');
        const closeBarButtonMobile = document.getElementById('CloseBarButtonMobile');
        const locationBtn = document.getElementById('locationBtn');

        if (locationBtn && regionBar) {
            // Store the handler reference
            this.handlers.locationBtnClick = function () {
                regionBar.style.display = 'block';
                regionBar.style.opacity = '1';
                locationBtn.classList.remove('active');
            };

            locationBtn.addEventListener('click', this.handlers.locationBtnClick);
        }

        this.setupCloseBarButton(closeBarButton, regionBar);
        this.setupCloseBarButton(closeBarButtonMobile, regionBar);
    },

    destroy() {
        // Use the stored handler references to remove event listeners
        if (this.handlers.closeAllSelect) {
            document.removeEventListener("click", this.handlers.closeAllSelect);
        }

        // Remove form event listeners
        const form = document.querySelector('.button-container');
        const continueButton = form?.querySelector('.submit-button');

        if (form && this.handlers.redirectToRegionalSite) {
            form.removeEventListener('submit', this.handlers.redirectToRegionalSite);
        }

        if (continueButton && this.handlers.redirectToRegionalSite) {
            continueButton.removeEventListener('click', this.handlers.redirectToRegionalSite);
        }

        // Remove location button event listener
        const locationBtn = document.getElementById('locationBtn');
        if (locationBtn && this.handlers.locationBtnClick) {
            locationBtn.removeEventListener('click', this.handlers.locationBtnClick);
        }

        // Restore original console.log if needed
        // Note: This is challenging to implement correctly
        // The best approach would be to store the original console.log in init()
    }
};