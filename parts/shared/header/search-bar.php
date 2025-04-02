<div class="search-bar" id="searchBar">
    <div class="close-search--btn" id="closeSearchBar">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.5057 1.09106L0.857178 18.7398" stroke-width="2"/>
            <path d="M18.5054 18.7398L0.856876 1.09106" stroke-width="2"/>
        </svg>
    </div>
    <div class="input-search--content">
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input class="input-search" type="search" placeholder="Search Hubexo APAC..."
                   id="contentSearch"
                   name="s"
                   value="<?php echo get_search_query(); ?>">
            <input class="submit-search" type="submit" value="Search">
        </form>
    </div>

    <div class="show--card-content">
        <div class="list--content-update">
            <div class="list--item">
                <img class="hover--thumbnail" src="">
                <h6 class="title--search"></h6>
                <p class="desc--search"></p>
            </div>
        </div>
    </div>
</div>


