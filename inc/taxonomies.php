<?php

namespace EightArms;



function registerTaxonomies()
{
  register_taxonomy(
    'location',
    ['post'],
    [
      'show_in_rest' => true,
      'label' => __('Location'),
      'rewrite' => ['slug' => 'location'],
      'hierarchical' => true,
    ]
  );
}

register_taxonomy_for_object_type("location", "post");

add_action('init', 'EightArms\registerTaxonomies');
