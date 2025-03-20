<div class="container location--search on-button" id="locationBtn">
    <div class="location--icon">
        <img src="http://54.252.222.112/wp-content/uploads/2024/09/yellow-world.svg" alt="" srcset="">
        <p class="text-region-bar-float">Asia Pacific</p>
    </div>
</div>

<script>
document.getElementById('locationBtn').addEventListener('click', function() {
    const homepageBanner = document.querySelector('.homepage-banner');
    if (homepageBanner && homepageBanner.classList.contains('short')) {
        homepageBanner.classList.remove('short');
    }
});
</script>