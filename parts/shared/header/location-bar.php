<?php
$titleLocationBar = get_field( 'title_location_banner', 'options' );
$textLocationBar  = get_field( 'text_location_banner', 'options' );
$show             = get_field( 'show_location_banner', 'options' );
?>
<?php if ( $show == "true" ): ?>

    <script>
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
                    'DA': 'NEE',
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

                const neeCountries = ['SE', 'DA', 'FI', 'NO', 'CZ', 'SK', 'PL', 'AT', 'CH'];// Added ID and AU to ensure they're included
                const otherRegionCountries = ['US', 'CA', 'GB', 'IE', 'ES', 'PT', 'DE'];

                const countryIsoMap = {
                    'AU': 'Australia',
                    'AT': 'Austria',
                    'CA': 'Canada',
                    'CZ': 'Czech Republic',
                    'DA': 'Denmark',
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

                        // if (regionBar) {
                        //     if (apacCountries.includes(currentCountryCode)) {
                        //         regionBar.classList.add('hidden');
                        //     } else if (otherRegionCountries.includes(currentCountryCode)) {
                        //         regionBar.classList.remove('hidden');
                        //     }
                        // }
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

                // Special mapping for country-specific URL parameters
                const countryParamOverrides = {
                    'DK': 'da'
                };

                // Function to get URL country parameter with fallback
                function getUrlCountryParam(isoCode) {
                    isoCode = isoCode.toUpperCase();
                    return countryParamOverrides[isoCode] || isoCode.toLowerCase();
                }


                function redirectToRegionalSite(event) {
                    event.preventDefault();
                    const selectedOption = select.options[select.selectedIndex];
                    const mainDomain = 'hubexo.com';

                    if (selectedOption && selectedOption.value) {
                        const region = selectedOption.value;
                        const selectedCountryName = selectedOption.textContent.trim();
                        const selectedCountryCode = getCountryCodeFromSelection(selectedCountryName);

                        // Get lowercase country code for the URL
                        const countryUrlCode = selectedCountryCode ? getUrlCountryParam(selectedCountryCode) : '';

                        // Check if we need to handle APAC special case
                        if (region === 'NEE') {
                            const currentRegion = countryRegionMap[currentCountryCode];
                            if (currentRegion === 'NEE') {
                                if (selectedCountryCode && selectedCountryCode !== currentCountryCode) {
                                    updateLocalStorageCountry(selectedCountryCode);
                                    window.location.href = `https://${region.toLowerCase()}.${mainDomain}/${countryUrlCode}`;
                                    return;
                                }
                            }
                        }

                        // Default redirection handling
                        if (countryUrlCode) {
                            window.location.href = `https://${region.toLowerCase()}.${mainDomain}/${countryUrlCode}`;
                        } else {
                            window.location.href = `https://${region.toLowerCase()}.${mainDomain}`;
                        }
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
    </script>

    <div class="region-bar" id="regionBar">
        <div class="container">
            <div class="bar-container">
                <div class="close-button--at-mobile" id="CloseBarButtonMobile">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.5057 1.09106L0.857178 18.7398" stroke-width="2"/>
                        <path d="M18.5054 18.7398L0.856876 1.09106" stroke-width="2"/>
                    </svg>
                </div>
                <div class="text-container">
                    <div class="title-and-icon">
                        <img src="https://apac.hubexo.com/wp-content/uploads/2024/09/yellow-world.svg" alt="" srcset="">
                        <p class="title-content--bar"><?= $titleLocationBar; ?></p>
                    </div>
                    <div class="description-banner">
                        <p><?= $textLocationBar; ?></p>
                    </div>
                </div>

                <form action="" class="button-container">
                    <div class="custom-select">
                        <select id="OptionCountry">
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Austria.svg' ); ?>" value="NEE">
                                Austria
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Australia.svg' ); ?>" value="APAC">
                                Australia
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Canada.svg' ); ?>" value="NA">Canada
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/CzechRepublic.svg' ); ?>"
                                    value="NEE">
                                Czech
                                Republic
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Denmark.svg' ); ?>" value="NEE">
                                Denmark
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Finland.svg' ); ?>" value="NEE">
                                Finland
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Germany.svg' ); ?>" value="WE">
                                Germany
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Hongkong.svg' ); ?>" value="APAC">
                                Hong
                                Kong
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Indonesia.svg' ); ?>" value="APAC">
                                Indonesia
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Ireland.svg' ); ?>" value="UKI">
                                Ireland
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Malaysia.svg' ); ?>" value="APAC">
                                Malaysia
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/NewZealand.svg' ); ?>" value="APAC">
                                New
                                Zealand
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Norway.svg' ); ?>" value="NEE">Norway
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Philippines.svg' ); ?>" value="APAC">
                                Philippines
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Poland.svg' ); ?>" value="NEE">Poland
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Portugal.svg' ); ?>" value="WE">
                                Portugal
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Singapore.svg' ); ?>" value="APAC">
                                Singapore
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Slovakia.svg' ); ?>" value="NEE">
                                Slovakia
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Spain.svg' ); ?>" value="WE">Spain
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Sweden.svg' ); ?>" value="NEE">Sweden
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Switzerland.svg' ); ?>" value="NEE">
                                Switzerland
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Thailand.svg' ); ?>" value="APAC">
                                Thailand
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/UnitedKingdom.svg' ); ?>"
                                    value="UKI">
                                United Kingdom
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/UnitedStates.svg' ); ?>" value="NA">
                                United
                                States
                            </option>
                            <option data-icon="<?php echo get_theme_file_uri( 'img/Vietnam.svg' ); ?>" value="APAC">
                                Vietnam
                            </option>
                        </select>
                    </div>

                    <div class="button-continue blueprint--button">
                        <input class="submit-button" type="submit" value="Continue">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.625156 8L13.8846 8" stroke="currentcolor" stroke-width="1.84615"
                                  stroke-miterlimit="10"></path>
                            <path d="M10.4715 15.3846C10.4715 11.3231 13.4254 8 17.0356 8" stroke="currentcolor"
                                  stroke-width="1.84615" stroke-miterlimit="10"></path>
                            <path d="M10.4715 0.617187C10.4715 4.67873 13.4254 8.0018 17.0356 8.0018"
                                  stroke="currentcolor"
                                  stroke-width="1.84615" stroke-miterlimit="10"></path>
                        </svg>
                    </div>

                    <div class="close-button" id="CloseBarButton">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5057 1.09106L0.857178 18.7398" stroke-width="2"/>
                            <path d="M18.5054 18.7398L0.856876 1.09106" stroke-width="2"/>
                        </svg>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif; ?>