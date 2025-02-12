<?php

$siteWideMessage = get_field('header_message', 'options');
$show = get_field('show_header_message', 'options');

?>
<?php if ($show == "true"): ?>

    <div class="header-message text-center small-para">
        <div class="container snug-child">
            <?= $siteWideMessage; ?>
            <button class="close">
                <span class="sr-only"><?php _e('Close banner', 'hubexo'); ?></span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.625" y="0.625" width="18.75" height="18.75" rx="9.375" stroke="#FAFAF0" stroke-width="1.25" />
                    <path d="M5.625 5.625L14.375 14.375" stroke="#FAFAF0" stroke-width="2" stroke-miterlimit="10" />
                    <path d="M14.375 5.625L5.625 14.375" stroke="#FAFAF0" stroke-width="2" stroke-miterlimit="10" />
                </svg>
            </button>
        </div>
    </div>

<?php endif; ?>