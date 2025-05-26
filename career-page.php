<?php /* Template Name: Career */ ?>

<?php
get_template_part('parts/shared/html-header');
get_template_part('parts/shared/header');

// Get ACF fields
$slug_title = get_field('slug_title');
$title = get_field('title');
$description = get_field('description');
$job_items = get_field('job_items');
?>

    <main class="aluminium-bg">
        <div class="flexible-content-panels">
            <div class="title-banner header-pad-two">
                <div class="container fade-up">
                    <div class="row">
                        <div class="col-12">
                            <div class="list-category-career">
                                <button class="btn-category-item"><?= $slug_title ?: "We're Hiring" ?></button>
                            </div>
                            <h1 class="page-title"><?= $title ?: "Career" ?></h1>
                            <div class="page-description">
                                <?= $description ?: '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut auctor eros.</p><p>Donec semper odio et sapien convallis tincidunt. Integer ex metus, interdum id dui vitae, bibendum viverra neque.</p><p>Vestibulum pretium elementum tortor, ut auctor lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>' ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <!--
                            <div class="list-category-career">
                                <button id="viewAll" class="btn-category-item">View All</button>
                                <button class="btn-category-item" data-category="development">Development</button>
                                <button class="btn-category-item" data-category="design">Design</button>
                                <button class="btn-category-item" data-category="marketing">Marketing</button>
                                <button class="btn-category-item" data-category="customer-service">Customer Service</button>
                            </div>
                            -->

                            <div class="list-category-career">
                                <button id="viewAll" class="btn-category-item">View All</button>
                                <?php
                                if (!empty($job_items)) :
                                    // Track displayed categories to avoid duplicates
                                    $displayed_categories = [];

                                    foreach ($job_items as $job) :
                                        // When return format is Both (Array), category_jobs contains both value and label
                                        $category = $job['category_jobs'];
                                        $category_value = isset($category['value']) ? $category['value'] : '';
                                        $category_label = isset($category['label']) ? $category['label'] : '';

                                        // Only display this category if we haven't already shown it
                                        if (!empty($category_value) && !isset($displayed_categories[$category_value])) :
                                            // Mark this category as displayed
                                            $displayed_categories[$category_value] = true;
                                            ?>
                                            <button class="btn-category-item" data-category="<?= esc_attr($category_value) ?>"><?= esc_html($category_label) ?></button>
                                        <?php
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="container fade-up container-job-list">
                    <div class="row">
                        <div class="col-12 flex gap-col">
                            <?php if (!empty($job_items)) : ?>
                                <?php foreach ($job_items as $job) : ?>
                                    <?php
                                    // When return format is Both (Array), category_jobs contains both value and label
                                    $category = $job['category_jobs'];
                                    $category_value = isset($category['value']) ? $category['value'] : '';
                                    $category_label = isset($category['label']) ? $category['label'] : '';
                                    ?>
                                    <div class="career-list-container" data-job-type="<?= esc_attr($category_value) ?>">
                                        <div class="career-list-head">
                                            <h4 class=""><?= $job['title'] ?></h4>
                                            <?php if (!empty($job['url_button'])) : ?>
                                                <a href="<?= $job['url_button'] ?>" class="btn-text"><?= $job['name_button'] ?: 'Apply' ?></a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="career-list-body">
                                            <?= $job['description'] ?>
                                        </div>
                                        <div class="career-list-category">
                                            <?php if (!empty($job['job_type'])) : ?>
                                                <?php foreach ($job['job_type'] as $job_type) : ?>
                                                    <?php if (!empty($job_type['icon_job_type']) && !empty($job_type['name_job_type'])) : ?>
                                                        <button>
                                                            <?php if (is_array($job_type['icon_job_type'])) : ?>
                                                                <img src="<?= esc_url($job_type['icon_job_type']['url']) ?>"
                                                                     alt="<?= esc_attr($job_type['name_job_type']) ?>"
                                                                     style="width: 24px; height: 24px; object-fit: contain;">
                                                            <?php endif; ?>
                                                            <span><?= esc_html($job_type['name_job_type']) ?></span>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="career-list-container">
                                    <div class="career-list-head">
                                        <h4 class="">No job openings available</h4>
                                    </div>
                                    <div class="career-list-body">
                                        <p>Currently, there are no job openings. Please check back later.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part('parts/shared/float-btn'); ?>
        <?php get_template_part('parts/shared/footer'); ?>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all category buttons
        const categoryButtons = document.querySelectorAll('.btn-category-item');

        // Get all job listings
        const jobListings = document.querySelectorAll('.career-list-container');

        // Add active class to View All button initially
        document.getElementById('viewAll').classList.add('active');

        // Add click event listener to each button
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add active class to clicked button
                this.classList.add('active');

                // Get the category from data attribute
                const category = this.getAttribute('data-category');

                // If View All button is clicked or no category is specified
                if (this.id === 'viewAll' || !category) {
                    // Show all job listings
                    jobListings.forEach(job => {
                        job.style.display = 'block';
                    });
                } else {
                    // Show only jobs that match the category
                    jobListings.forEach(job => {
                        if (job.getAttribute('data-job-type') === category) {
                            job.style.display = 'block';
                        } else {
                            job.style.display = 'none';
                        }
                    });
                }
            });
        });
    });
</script>

<?php get_template_part('parts/shared/html-footer'); ?>