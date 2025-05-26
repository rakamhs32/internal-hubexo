<?php

namespace EightArms;

function preGetPosts($query)
{
  if (!is_admin() && $query->is_main_query() && $query->is_home()) {
    $featured_posts = get_field('featured_post', get_option('page_for_posts'));
    if ($featured_posts) {
      $query->set('post__not_in', array_map(function ($p) {
        return $p->ID;
      }, $featured_posts));
    }
  }
}

add_action('pre_get_posts', 'EightArms\preGetPosts');
