<div class="container">
    <div class="post-navigation">
        <div class="previous-post">
            <?php
            $prev_post = get_previous_post();
            if (empty($prev_post)) {
                // If no previous post, get the last post to loop
                $prev_post = get_posts(array(
                    'posts_per_page' => 1,
                    'order' => 'DESC'
                ));
                if (! empty($prev_post)) {
                    $prev_post = $prev_post[0];
                }
            }
            if (! empty($prev_post)) {
                $prev_post_url = get_permalink($prev_post);
                $prev_post_title = get_the_title($prev_post);
                echo '<a href="' . esc_url($prev_post_url) . '">
                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="30.1421" height="30.1421" rx="15.0711" transform="matrix(-1 0 0 1 30.4785 0.929138)" fill="#DCFF3C"/>
                        <g clip-path="url(#clip0_4019_13261)">
                        <path d="M10.1055 14.2324L17.1765 21.3035" stroke="#321432" stroke-width="5" stroke-miterlimit="10"/>
                        <path d="M17.1758 10.6969L10.1047 17.768" stroke="#321432" stroke-width="5" stroke-miterlimit="10"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_4019_13261">
                        <rect width="10" height="10" fill="white" transform="matrix(-0.707107 0.707107 0.707107 0.707107 15.4082 8.92914)"/>
                        </clipPath>
                        </defs>
                    </svg>
                    Prev<span>ious</span><span>&nbsp;article</span>
                </a>';
            }
            ?>
        </div>

        <div class="next-post">
            <?php
            $next_post = get_next_post();
            if (empty($next_post)) {
                // If no next post, get the first post to loop
                $next_post = get_posts(array(
                    'posts_per_page' => 1,
                    'order' => 'ASC'
                ));
                if (! empty($next_post)) {
                    $next_post = $next_post[0];
                }
            }
            if (! empty($next_post)) {
                $next_post_url = get_permalink($next_post);
                $next_post_title = get_the_title($next_post);
                echo '<a href="' . esc_url($next_post_url) . '">Next<span>&nbsp;article</span>
                <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="30.1421" height="30.1421" rx="15.0711" transform="matrix(1 0 0 -1 0.193359 31.071)" fill="#DCFF3C"/>
                    <g clip-path="url(#clip0_4019_13270)">
                    <path d="M20.5664 17.7678L13.4953 10.6967" stroke="#321432" stroke-width="5" stroke-miterlimit="10"/>
                    <path d="M13.4961 21.3033L20.5672 14.2322" stroke="#321432" stroke-width="5" stroke-miterlimit="10"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_4019_13270">
                    <rect width="10" height="10" fill="white" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 15.2637 23.071)"/>
                    </clipPath>
                    </defs>
                </svg>
                </a>';
            }
            ?>
        </div>
    </div>
</div>