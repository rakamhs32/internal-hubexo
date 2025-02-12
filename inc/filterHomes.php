<?php

function getCareHomeRegions()
{
  // Check for transient. If none, then execute WP_Query
  // if (false === ($regions = get_transient('care_home_regions'))) {
  $regionPages = new WP_Query(
    array(
      'post_type' => 'page',
      'post_parent' => AREAS_WE_COVER_ID,
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
    )
  );

  $regions = [];
  foreach ($regionPages->posts as $region) :

    $regions[$region->ID] = [
      "name" => $region->post_title,
      "id" => $region->ID,
      "home_ids" => [],
    ];
    $fields = get_fields($region->ID);

    foreach ($fields['care_homes'] as $home) :
      $regions[$region->ID]['home_ids'][] = $home->ID;
    endforeach;

  endforeach;

  // Put the results in a transient. Expire after 60 seconds
  //   set_transient('care_home_regions', $regions, 60);
  // }

  return $regions;
}


function addRegionToHomes($homes, $regions)
{
  $newHomes = [];
  foreach ($homes as $home) :
    $newHomes[$home->ID] = $home;
    $newHomes[$home->ID]->region_ids = [];
  endforeach;

  foreach ($regions as $region) :
    foreach ($region['home_ids'] as $home_id) :
      $newHomes[$home_id]->region_ids[] = $region['id'];
    endforeach;
  endforeach;

  return array_values($newHomes);
}
