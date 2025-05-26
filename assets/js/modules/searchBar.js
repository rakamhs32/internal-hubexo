export default {
    init() {
        // Country code to region mapping
        const countryRegionMap = {
            'AU': 'Asia Pacific',
            'NZ': 'Asia Pacific',
            'SG': 'Asia Pacific',
            'MY': 'Asia Pacific',
            'ID': 'Asia Pacific',
            'HK': 'Asia Pacific',
            'PH': 'Asia Pacific',
            'TH': 'Asia Pacific',
            'VN': 'Asia Pacific',
            'US': 'North America',
            'CA': 'North America',
            'SE': 'North East Europe',
            'DK': 'North East Europe',
            'FI': 'North East Europe',
            'NO': 'North East Europe',
            'CZ': 'North East Europe',
            'SK': 'North East Europe',
            'PL': 'North East Europe',
            'GB': 'UKI',
            'IE': 'UKI',
            'ES': 'West Europe',
            'PT': 'West Europe',
            'AT': 'West Europe',
            'CH': 'West Europe',
            'DE': 'West Europe'
        };

        // Update region title based on country data
        const updateRegionTitle = () => {
            const countryDataString = localStorage.getItem('country_data');
            if (countryDataString) {
                try {
                    const countryData = JSON.parse(countryDataString);
                    const countryCode = countryData.iso_code;
                    const region = countryRegionMap[countryCode] || '';

                    const titleElement = document.querySelector('.text-region-bar');
                    if (titleElement && region) {
                        titleElement.textContent = `${region}`;
                    }
                } catch (e) {
                    console.error('Error parsing country data:', e);
                }
            }
        };

        // Debounce function
        const debounce = (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };

        // Perform search
        const performSearch = (inputElement, listContentUpdate, showCardContent, loadingDiv, listItem) => {
            const searchTerm = inputElement.value.trim();

            if (searchTerm.length < 2) {
                listContentUpdate.innerHTML = '';
                showCardContent.classList.remove('active');
                loadingDiv.style.display = 'none';
                return;
            }

            loadingDiv.style.display = 'flex';
            showCardContent.classList.add('active');
            listContentUpdate.innerHTML = '';

            fetch(`${wp_ajax_object.ajax_url}?action=hubexo_search&query=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    loadingDiv.style.display = 'none';
                    if (data.success && data.data.length > 0) {
                        listContentUpdate.innerHTML = '';
                        data.data.forEach(result => {
                            const itemClone = listItem.cloneNode(true);

                            // Add the title
                            itemClone.querySelector('.title--search').textContent = result.title;

                            // Add the link URL - using 'link' as returned by PHP
                            const linkElement = itemClone.querySelector('.link--title');
                            if (linkElement && result.link) {
                                linkElement.href = result.link;
                            }

                            // Add the excerpt/description
                            const descElement = itemClone.querySelector('.desc--search');
                            if (descElement && result.excerpt) {
                                descElement.textContent = result.excerpt;
                            }

                            // Add the thumbnail if available
                            const thumbnailElement = itemClone.querySelector('.hover--thumbnail');
                            if (thumbnailElement && result.thumbnail) {
                                // Check if thumbnail exists and is not empty
                                if (result.thumbnail.trim() !== '') {
                                    thumbnailElement.src = result.thumbnail;
                                    thumbnailElement.alt = result.title; // Optional: set alt text
                                    thumbnailElement.style.display = 'block'; // Ensure it's visible
                                } else {
                                    thumbnailElement.style.display = 'none'; // Hide if no thumbnail
                                }
                            } else if (thumbnailElement) {
                                thumbnailElement.style.display = 'none'; // Hide if thumbnail property doesn't exist
                            }

                            listContentUpdate.appendChild(itemClone);
                        });
                    } else {
                        listContentUpdate.innerHTML = '<p>No results found.</p>';
                    }
                })
                .catch(error => {
                    loadingDiv.style.display = 'none';
                    console.error('Search error:', error);
                });
        };

        const performSearchMobile = (inputElement, listContentUpdateMobile, showCardContentMobile, loadingDivMobile, v) => {
            const searchTermMobile = inputElement.value.trim();

            if (searchTermMobile.length < 2) {
                listContentUpdateMobile.innerHTML = '';
                showCardContentMobile.classList.remove('active');
                loadingDivMobile.style.display = 'none';
                return;
            }

            loadingDivMobile.style.display = 'flex';
            showCardContentMobile.classList.add('active');
            listContentUpdateMobile.innerHTML = '';

            fetch(`${wp_ajax_object.ajax_url}?action=hubexo_search&query=${encodeURIComponent(searchTermMobile)}`)
                .then(response => response.json())
                .then(data => {
                    loadingDivMobile.style.display = 'none';
                    if (data.success && data.data.length > 0) {
                        listContentUpdate.innerHTML = '';
                        data.data.forEach(result => {

                            // const itemClone = listItemMobile.cloneNode(true);
                            // itemClone.querySelector('.title--search-mobile').textContent = result.title;

                            // Add the title
                            const itemClone = listItemMobile.cloneNode(true);
                            itemClone.querySelector('.title--search-mobile').textContent = result.title;

                            // Add the link URL - using 'link' as returned by PHP
                            const linkElementMobile = itemClone.querySelector('.link--title-mobile');
                            if (linkElementMobile && result.link) {
                                linkElementMobile.href = result.link;
                            }

                            // Add the excerpt/description
                            const descElementMobile = itemClone.querySelector('.desc--search-mobile');
                            if (descElementMobile && result.excerpt) {
                                descElementMobile.textContent = result.excerpt;
                            }

                            // Add the thumbnail if available
                            const thumbnailElementMobile = itemClone.querySelector('.hover--thumbnail-mobile');
                            if (thumbnailElementMobile && result.thumbnail) {
                                // Check if thumbnail exists and is not empty
                                if (result.thumbnail.trim() !== '') {
                                    thumbnailElementMobile.src = result.thumbnail;
                                    thumbnailElementMobile.alt = result.title; // Optional: set alt text
                                    thumbnailElementMobile.style.display = 'block'; // Ensure it's visible
                                } else {
                                    thumbnailElementMobile.style.display = 'none'; // Hide if no thumbnail
                                }
                            } else if (thumbnailElementMobile) {
                                thumbnailElementMobile.style.display = 'none'; // Hide if thumbnail property doesn't exist
                            }

                            listContentUpdateMobile.appendChild(itemClone);
                        });
                    } else {
                        listContentUpdateMobile.innerHTML = '<p>No results found.</p>';
                    }
                })
                .catch(error => {
                    loadingDivMobile.style.display = 'none';
                    console.error('Search error:', error);
                });
        };

        // Desktop search bar elements
        const menuItem = document.getElementById('menu-item-1759');
        const searchBar = document.getElementById('searchBar');
        const closeButton = document.getElementById('closeSearchBar');
        const contentSearch = document.getElementById('contentSearch');
        const listContentUpdate = document.querySelector('.list--content-update');
        const listItem = document.querySelector('.list--item');
        const showCardContent = document.querySelector('.show--card-content');
        const loadingDivDesktop = document.createElement('div');
        loadingDivDesktop.className = 'search-loading';
        loadingDivDesktop.textContent = 'Loading';
        loadingDivDesktop.style.display = 'none';
        listContentUpdate.parentNode.insertBefore(loadingDivDesktop, listContentUpdate);

        // Mobile search bar elements
        const menuItemMobile = document.getElementById('searchMobileButton');
        const searchBarMobile = document.getElementById('searchBarMobile');
        const closeButtonMobile = document.getElementById('closeSearchBarMobile');
        const contentSearchMobile = document.getElementById('contentSearchMobile');
        const listContentUpdateMobile = document.querySelector('.list--content-update-mobile');
        const listItemMobile = document.querySelector('.list--item-mobile');
        const showCardContentMobile = document.querySelector('.show--card-content-mobile');
        const loadingDivMobile = document.createElement('div');
        loadingDivMobile.className = 'search-loading-mobile';
        loadingDivMobile.textContent = 'Loading';
        loadingDivMobile.style.display = 'none';
        listContentUpdateMobile.parentNode.insertBefore(loadingDivMobile, listContentUpdateMobile);

        // Event listeners for desktop
        const openSearchBarDesktop = (e) => {
            e.preventDefault();
            searchBar.classList.add('active');
        };
        const closeSearchBarDesktop = () => searchBar.classList.remove('active');
        const searchDesktop = debounce(() => performSearch(contentSearch, listContentUpdate, showCardContent, loadingDivDesktop, listItem), 500);

        if (menuItem && searchBar) {
            menuItem.querySelector('a').addEventListener('click', openSearchBarDesktop);
            closeButton.addEventListener('click', closeSearchBarDesktop);
            contentSearch.addEventListener('input', searchDesktop);
        }

        // Event listeners for mobile
        const openSearchBarMobile = (e) => {
            e.preventDefault();
            searchBarMobile.classList.add('active');
        };
        const closeSearchBarMobile = () => searchBarMobile.classList.remove('active');
        const searchMobile = debounce(() => performSearchMobile(contentSearchMobile, listContentUpdateMobile, showCardContentMobile, loadingDivMobile, listItemMobile), 500);

        if (menuItemMobile && searchBarMobile) {
            menuItemMobile.addEventListener('click', openSearchBarMobile);
            closeButtonMobile.addEventListener('click', closeSearchBarMobile);
            contentSearchMobile.addEventListener('input', searchMobile);
        }

        // Initialize region title
        updateRegionTitle();

        // Store event listeners for cleanup
        this.eventListeners = {
            desktop: {openSearchBarDesktop, closeSearchBarDesktop, searchDesktop},
            mobile: {openSearchBarMobile, closeSearchBarMobile, searchMobile}
        };
    },

    destroy() {
        // Remove all event listeners for desktop
        const {desktop, mobile} = this.eventListeners;

        const menuItem = document.getElementById('menu-item-1759');
        const searchBar = document.getElementById('searchBar');
        const closeButton = document.getElementById('closeSearchBar');
        const contentSearch = document.getElementById('contentSearch');

        if (menuItem && searchBar) {
            menuItem.querySelector('a').removeEventListener('click', desktop.openSearchBarDesktop);
            closeButton.removeEventListener('click', desktop.closeSearchBarDesktop);
            contentSearch.removeEventListener('input', desktop.searchDesktop);
        }

        // Remove all event listeners for mobile
        const menuItemMobile = document.getElementById('searchMobileButton');
        const searchBarMobile = document.getElementById('searchBarMobile');
        const closeButtonMobile = document.getElementById('closeSearchBarMobile');
        const contentSearchMobile = document.getElementById('contentSearchMobile');

        if (menuItemMobile && searchBarMobile) {
            menuItemMobile.removeEventListener('click', mobile.openSearchBarMobile);
            closeButtonMobile.removeEventListener('click', mobile.closeSearchBarMobile);
            contentSearchMobile.removeEventListener('input', mobile.searchMobile);
        }
    }
};
