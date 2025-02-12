<?php

define('GOOGLE_MAPS_API_KEY', '');

function my_acf_init()
{
    acf_update_setting('google_api_key', GOOGLE_MAPS_API_KEY);
}
add_action('acf/init', 'my_acf_init');
