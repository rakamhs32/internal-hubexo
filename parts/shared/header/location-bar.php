<div class="region-bar" id="regionBar">
    <div class="container">
        <div class="bar-container">
            <div class="close-button--at-mobile" id="CloseBarButtonMobile">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.5057 1.09106L0.857178 18.7398" stroke-width="2" />
                    <path d="M18.5054 18.7398L0.856876 1.09106" stroke-width="2" />
                </svg>
            </div>
            <div class="text-container">
                <div class="title-and-icon">
                    <svg width="17" height="24" viewBox="0 0 17 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 24L6.99326 21.5984C4.60212 17.7754 0 12.6617 0 8.47924C0 3.79033 3.79961 0 8.5 0C13.2004 0 17 3.79033 17 8.47924C17 12.6617 12.3979 17.7917 10.0067 21.5984L8.5 24ZM8.5 3.70865C5.8632 3.70865 3.71773 5.84888 3.71773 8.47924C3.71773 11.1096 5.8632 13.2498 8.5 13.2498C11.1368 13.2498 13.2823 11.1096 13.2823 8.47924C13.2823 5.84888 11.1368 3.70865 8.5 3.70865Z" fill="#414344" />
                    </svg>
                    <p class="title-content--bar">Your are viewing content for Hubexo Global</p>
                </div>
                <div class="description-banner">
                    <p>Choose a country to see content relevant to you</p>
                    <p>Changing country will navigate you to your regional website homepage.</p>
                </div>
            </div>
            <form action="" class="button-container">
                <div class="custom-select">
                    <select>
                        <option value="APAC">Australia</option>
                        <option value="APAC">New Zealand</option>
                        <option value="APAC">Singapore</option>
                        <option value="APAC">Malaysia</option>
                        <option value="APAC">Indonesia</option>
                        <option value="APAC">Hong Kong</option>
                        <option value="APAC">Philippines</option>
                        <option value="APAC">Thailand</option>
                        <option value="APAC">Vietnam</option>
                        <option value="NA">United States</option>
                        <option value="NA">Canada</option>
                        <option value="NEE">Sweden</option>
                        <option value="NEE">Denmark</option>
                        <option value="NEE">Finland</option>
                        <option value="NEE">Norway</option>
                        <option value="NEE">Czech Republic</option>
                        <option value="NEE">Slovakia</option>
                        <option value="NEE">Poland</option>
                        <option value="UKI">United Kingdom</option>
                        <option value="UKI">Ireland</option>
                        <option value="WE">Spain</option>
                        <option value="WE">Portugal</option>
                    </select>
                </div>

                <div class="button-continue blueprint--button mail--button">
                    <input class="submit-button" type="submit" value="Continue"><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.625156 8L13.8846 8" stroke="currentcolor" stroke-width="1.84615" stroke-miterlimit="10"></path>
                        <path d="M10.4715 15.3846C10.4715 11.3231 13.4254 8 17.0356 8" stroke="currentcolor" stroke-width="1.84615" stroke-miterlimit="10"></path>
                        <path d="M10.4715 0.617187C10.4715 4.67873 13.4254 8.0018 17.0356 8.0018" stroke="currentcolor" stroke-width="1.84615" stroke-miterlimit="10"></path>
                    </svg>
                </div>

                <div class="close-button" id="CloseBarButton">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.5057 1.09106L0.857178 18.7398" stroke-width="2" />
                        <path d="M18.5054 18.7398L0.856876 1.09106" stroke-width="2" />
                    </svg>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const originalConsoleLog = console.log;

    console.log = function(...args) {
        originalConsoleLog.apply(console, args);
        if (args.length > 0 && typeof args[0] === 'object') {
            const data = args[0];
            if (data.geo && data.geo.country && data.geo.country.data) {
                const countryData = data.geo.country.data;
                const countryInfo = {
                    iso_code: countryData.iso_code,
                    names: countryData.names
                };
                localStorage.setItem('country_data', JSON.stringify(countryInfo));
                console.log('Country data saved to local storage:', countryInfo);
            }
        }
    };
</script>

<script>
    var x, i, j, l, ll, selElmnt, a, b, c;
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }
    document.addEventListener("click", closeAllSelect);

    document.addEventListener('DOMContentLoaded', function() {
        const closeBarButtonMobile = document.getElementById('CloseBarButtonMobile');
        const closeBarButton = document.getElementById('CloseBarButton');
        const regionBar = document.getElementById('regionBar');

        if (closeBarButton && regionBar) {
            setupCloseBarButton(closeBarButton, regionBar);
        }

        if (closeBarButtonMobile && regionBar) {
            setupCloseBarButton(closeBarButtonMobile, regionBar);
        }
    });

    function setupCloseBarButton(button, element) {
        button.addEventListener('click', function() {
            element.classList.add('close-bar');
        });
    }
</script>