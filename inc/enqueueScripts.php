<?php

namespace EightArms;

function enqueueScripts()
{
  $files = json_decode(file_get_contents(dirname(__DIR__) . '/mix-manifest.json.backup'));
  $mainJS = $files->{'/dist/main.js'};
  $mainCSS = $files->{'/dist/style.css'};
  wp_enqueue_style('global-css', get_template_directory_uri() . $mainCSS);
  wp_enqueue_script('global-js', get_template_directory_uri() . $mainJS, false, false, true);
}
add_action('wp_enqueue_scripts', 'EightArms\enqueueScripts');
