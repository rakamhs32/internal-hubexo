<?php
// Needs getImageAttributes in helpers.php
['image' => $image, 'attributes' => $attributes] = getImageAttributes($args);
if (!$image) {
  echo "<!-- No image -->";
  return;
}
?>
<!-- small.php -->
<img loading="lazy" src="<?= $image['sizes']['2048x2048']; ?>" alt="<?= $image['alt']; ?>" width="<?= $image['width'] ?>" height="<?= $image['height'] ?>" <?= $attributes ?> />