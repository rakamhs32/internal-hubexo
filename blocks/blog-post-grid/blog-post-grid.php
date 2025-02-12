<div class="content-panel no-bg">
    <div class="container">
        <div class="blog-post--grid-title">
            <h2><?= the_field('title') ?></h2>
        </div>
        <div class="blog-post-grid sec-post-grid" id="posts-wrap">
            <?php
            $blogs = new WP_Query([
                'post_type' => array(''),
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'category_name' => '',
                'orderby' => 'date',
                'order' => 'DESC',

            ]);

            if ($blogs->have_posts()) :
                $count = 1;
                while ($blogs->have_posts()) : $blogs->the_post();

            ?>

                    <div class="blog-post-block fade-in">
                        <a href="<?= the_permalink(); ?>" class="block-link">
                            <div class="image-wrap">
                                <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
                            </div>
                            <div class="blog-post-block--text">
                                <span class="blog-post-block--meta"><span><?php echo get_the_date('j M Y'); ?></span>
                                    <!-- <?php if ($locations): ?><span class="blog-post-block--meta-locations"><?= $locations ?></span><?php endif ?> -->
                                </span>
                                <h3 class="small-title--bold blog-post-block--title"><?= the_title(); ?></h3>
                            </div>
                            <button class="blueprint--button hover">
                                Read more
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.62281 12L19.8828 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                    <path d="M16.4711 19.3846C16.4711 15.3231 19.4249 12 23.0352 12" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                    <path d="M16.4711 4.61719C16.4711 8.67873 19.4249 12.0018 23.0352 12.0018" stroke="currentColor" stroke-width="1.84615" stroke-miterlimit="10" />
                                </svg>
                            </button>
                        </a>
                        <?php // the_category(); 
                        ?>
                    </div>

            <?php
                    $count++;
                endwhile;
            else :
                echo esc_html__('Sorry, no posts matched your criteria.', 'hubexo');
            endif;

            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>