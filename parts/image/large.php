<?php
// Needs getImageAttributes in helpers.php
['image' => $image, 'attributes' => $attributes] = getImageAttributes($args);
if (!$image) {
  echo "<!-- No image -->";
  return;
}
?>
<!-- large.php -->
<picture>
  <source srcset="<?= $image['sizes']['medium_large']; ?>" media="(max-width: 575px)">
  <source srcset="<?= $image['sizes']['large']; ?>" media="(max-width: 1024px)">
  <source srcset="<?= $image['sizes']['2048x2048']; ?>">
  <img loading="lazy" src="<?= $image['sizes']['2048x2048']; ?>" alt="<?= $image['alt']; ?>" width="<?= $image['width'] ?>" height="<?= $image['height'] ?>" <?= $attributes ?> />
</picture>