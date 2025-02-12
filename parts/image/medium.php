<?php
// Needs getImageAttributes in helpers.php
['image' => $image, 'attributes' => $attributes] = getImageAttributes($args);
if (!$image) {
  echo "<!-- No image -->";
  return;
}
?>
<!-- medium.php -->
<picture>
  <source srcset="<?= $image['sizes']['medium_large']; ?>" media="(max-width: 575px)">
  <source srcset="<?= $image['sizes']['large']; ?>">
  <img loading="lazy" src="<?= $image['sizes']['large']; ?>" alt="<?= $image['alt']; ?>" width="<?= $image['width'] ?>" height="<?= $image['height'] ?>" <?= $attributes ?> />
</picture>