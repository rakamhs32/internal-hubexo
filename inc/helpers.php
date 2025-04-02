<?php

/** Usage:
 * <div class="block-name" <?= getBlockId($block) ?>>
 */
function getBlockId($block)
{
  $anchor = $block['anchor'] ?? false;
  if (! $anchor) {
    return '';
  }
  return ' id="' . $anchor . '"';
}

add_post_type_support('page', 'excerpt');
remove_filter('term_description', 'wpautop');

function remove_h1_from_tinymce_formats($init_array) {
  // Define the block formats you want to keep
  $init_array['block_formats'] = 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre';
  
  return $init_array;
}
add_filter('tiny_mce_before_init', 'remove_h1_from_tinymce_formats');

add_filter('next_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes()
{
  return 'class="next-link blueprint--button"';
}

function print_a($thing)
{
  echo "<pre>";
  print_r($thing);
  echo "</pre>";
}


function getQueryParam($param)
{
  global $wp_query;
  // print_a($wp_query);
  if (property_exists($wp_query, 'query')) {
    if (array_key_exists($param, $wp_query->query)) {
      return $wp_query->query[$param];
    }
  }
  return false;
}

function getFeaturedImages($args = [])
{
  $defaults = [
    'post' => false,
    'className' => false,
    'maxSize' => false,
    'stopIfSize' => false,
    'single' => false,
    'size' => 'large'
  ];
  $args = array_merge($defaults, $args);
  // From menus-and-image-sizes.php
  global $responsiveImageSizes;
  // Set defaults...
  if (!$args['post']) {
    global $post;
    $args['post'] = $post;
  }
  if (!$args['className']) {
    $args['className'] = 'post-featured-image-' . $args['post']->ID;
  }
  if (has_post_thumbnail($args['post'])) {
    $thumbnailId = get_post_thumbnail_id($args['post']->ID);
  } else {
    $thumbnailId = 6290;
    if ($args['single']) {
      return get_stylesheet_directory_uri() . '/images/default.jpg';
    }
  }

  if ($args['single']) {
    $imageInfo = wp_get_attachment_image_src($thumbnailId, $args['size']);
    return $imageInfo[0];
  }

  $styles = '';
  $first = true;
  foreach ($responsiveImageSizes as $size) {
    // If there is a max size set, ignore every
    // image size until we reach that size.
    if ($args['maxSize'] && $size['name'] != $args['maxSize']) {
      continue;
    }
    if ($args['stopIfSize'] && $size['name'] == $args['stopIfSize']) {
      break;
    }
    $args['maxSize'] = false;

    // Get the featured image at the correct size
    $image = wp_get_attachment_image_src($thumbnailId, $size['name']);
    $imageUrl = $image[0];

    // Layout two "templates"
    $mediaQuery = "@media(max-width: __WIDTH__px){\n  __STYLE__\n}\n";
    $style = ".__CLASSNAME__{ background-image: url('__IMAGEURL__'); }\n";

    // fill the style template with the correct values
    $style = str_replace('__CLASSNAME__', $className, $style);
    $style = str_replace('__IMAGEURL__', $imageUrl, $style);

    // If this isn't the default image, set a media
    // query for the same size as it
    if (!$first) {
      $style = str_replace('__STYLE__', $style, $mediaQuery);
      $style = str_replace('__WIDTH__', $size['width'], $style);
    }

    // Add it to the style tag
    $styles .= $style;

    $first = false;
  }
  $styles = "<style>{$styles}</style>";
  global $footerStyles;
  $footerStyles[] = $styles;
  return $className;
}

function getPrimaryCategory($post = false, $image = false)
{
  if (!$post) global $post;
  $return = [];
  $cat = new WPSEO_Primary_Term('category', $post->ID);
  $cat = $cat->get_primary_term();
  if (!$cat) return false;
  $term = get_term($cat, 'category');
  return $term;
}

function getSizeFromField($field)
{
  $size = size_format(filesize(get_attached_file($field['ID'])));
  return str_replace(' ', '', strtolower($size));
}

function homePostFields($post)
{
  $post->image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
  $post->mobileImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'mobile');
  $post->comingSoon = get_field('coming_soon', $post->ID);

  $post->postCode = get_field('postcode', $post->ID);

  $post->comingSoonText = get_field('coming_soon_text', $post->ID);

  $excerpt = $post->post_excerpt;
  if (empty($excerpt)) {
    $excerpt = wp_trim_words($post->post_content, 55, '...');
  }
  $post->excerpt = $excerpt;
  $post->link = get_permalink($post->ID);




  $tel = get_field('telephone_number', $post->ID);
  $telStr = strval($tel);
  $post->telNoSpace =  preg_replace('/\s+/', '', $telStr);
  $post->tel = $tel;

  $email = get_field('email_address', $post->ID);
  $post->email = antispambot($email);
  $post->facebook = get_field('facebook_link', $post->ID);
  $post->address = get_field('address', $post->ID);
  $post->whatThreeWords = get_field('what_three_words', $post->ID);
  $post->map = get_field('map', $post->ID);

  return $post;
}

function arrayToHtmlAttributes($attrs)
{
  return implode(" ", array_map(function ($key) use ($attrs) {
    return $key . '="' . $attrs[$key] . '"';
  }, array_keys($attrs)));
}

// Used by small.php, medium.php and large.php in /parts/image
function getImageAttributes($args)
{
  $image = false;
  $attrs = [];
  $defaultAttributes = ["loading" => "lazy"];

  if (!is_array($args)) {
    // Check for ACF image:
  } elseif (isset($args['type']) && $args['type'] == 'image') {
    $image = $args;
  } elseif (isset($args['image'])) {
    $image = $args['image'];
    unset($args['image']);
    $attrs = $args;
  }
  if (!$image) {
    return [
      'image' => false,
      'attributes' => [],
    ];
  }

  $attrs = array_merge($defaultAttributes, $attrs);

  $attributes = arrayToHtmlAttributes($attrs);

  return [
    'image' => $image,
    'attributes' => $attributes,
  ];
}
