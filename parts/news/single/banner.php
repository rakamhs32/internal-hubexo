<?php
$postTags = get_the_tags();
$category = get_the_category();
?>

<div class="header-pad single-post-banner">
    <div class="container">
        <h1 class="h4 snug single-post-title"><?= the_title(); ?></h1>
    </div>
</div>