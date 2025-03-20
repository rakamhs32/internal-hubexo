<?php

$title = get_field('title');
$teamMembers = get_field('team_members');

$selectCountry = get_field('select_country'); // Get the selected countries as an array
if ($selectCountry && is_array($selectCountry)) {
    $countries = implode(',', $selectCountry);
} else {
    $countries = '';
}
?>

<div class="content-panel team aluminium-bg" data-country="<?= esc_attr($countries) ?>">
    <div class="container">
        <h2 class="h5 snug"><?= $title; ?></h2>
        <div class="grid">
            <div class="grid-sizer"></div>
            <?php foreach ($teamMembers as $teamMember):
                $name = $teamMember['name'];
                $jobTitle = $teamMember['job_title'];
                $image = $teamMember['image'];
                $bio = $teamMember['bio'];
                $email = $teamMember['email'] ?? false;

            ?>
                <div class="team-member grid-item fade-in">
                    <div class="team-member--meta">
                        <div class="team-member--title">
                            <h3 class="small-title--bold snug"><?= $name; ?></h3>
                            <p class="snug"><?= $jobTitle; ?></p>
                        </div>
                        <div class="team-member--image">
                            <?php if ($image): ?>
                                <img src="<?= $image['sizes']['thumbnail']; ?>" alt="<?= $image['alt']; ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="team-member--bio snug-child">
                        <?= $bio; ?>
                    </div>
                    <button class="team-member--button"><span class="button--text">Show more</span> <?php get_template_part('parts/svg/down-arrow'); ?></button>
                    <?php if (!empty($email)): ?>
                        <a href="<?= antispambot($email['url']); ?>" class="blueprint--button"><?= $email['title'] ?> <?php // get_template_part('parts/svg/right-arrow'); 
                                                                                                                        ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>