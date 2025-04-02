<?php
get_template_part('parts/shared/html-header');
get_template_part('parts/shared/header');
?>
    <main class="search-results-page header-pad-searchbar">
        <div class="container">
            <header class="page-header">
                <h1 class="page-title-searchbar">
                    <?php
                    if (have_posts()) {
                        printf(
                        /* translators: %s: search term */
                            esc_html__('Search Results for: %s', 'your-theme-text-domain'),
                            '<span>' . esc_html(get_search_query()) . '</span>'
                        );
                    } else {
                        esc_html_e('Nothing Found', 'your-theme-text-domain');
                    }
                    ?>
                </h1>
            </header>

            <?php if (have_posts()) : ?>
                <div class="search-results-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                            <div class="search-result-content">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="search-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="search-text-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>
                                        <div class="post-meta">
                                            <?php if (get_post_type() !== 'page') : ?>
                                                <span class="post-type-label">
                                                    <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                                </span>
                                                <span>|</span>
                                                <span class="post-date">
                                                    <?php echo get_the_date(); ?>
                                                </span>
                                            <?php else : ?>
                                                <span class="post-type-label">
                                                    <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                    </header>

                                    <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'your-theme-text-domain'),
                    'next_text' => __('Next', 'your-theme-text-domain'),
                    'class' => 'pagination-search',
                    'screen_reader_text' => ' ',
                ));
                ?>

            <?php else : ?>
                <div class="no-results">
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'your-theme-text-domain'); ?></p>
                    <!-- <?php get_search_form(); ?> -->
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select both close buttons by their IDs
            const closeBarButtonMobile = document.getElementById('CloseBarButtonMobile');
            const closeBarButton = document.getElementById('CloseBarButton');

            // Function to add header-searchbar class
            function addHeaderSearchbarClass() {
                // Select elements with both 'search-results-page' and 'header-pad-searchbar' classes
                const targetElements = document.querySelectorAll('.search-results-page.header-pad-searchbar');

                // Add the 'header-searchbar' class to all matching elements
                targetElements.forEach(element => {
                    element.classList.add('header-searchbar');
                });
            }

            // Add event listener for CloseBarButtonMobile if it exists
            if (closeBarButtonMobile) {
                closeBarButtonMobile.addEventListener('click', addHeaderSearchbarClass);
            }

            // Add event listener for CloseBarButton if it exists
            if (closeBarButton) {
                closeBarButton.addEventListener('click', addHeaderSearchbarClass);
            }
        });
    </script>
<?php get_template_part('parts/shared/footer'); ?>
<?php get_template_part('parts/shared/html-footer'); ?>