<?php 

use Vinkla\Instagram\Instagram;

class InstagramHelper
{

  private $transientId = 'instgramFeed';
  private $limit = 18;
  private $cacheTime = DAY_IN_SECONDS; // DAY_IN_SECONDS
	// This can be generated as long as you are signed in here: instagram.pixelunion.net
  private $accessToken = INSTAGRAM_ACCESS_TOKEN;

  public $feed = false;

  private function fetchExternal()
  {
    $instagram = new Instagram($this->accessToken);
    $result = $instagram->get();
    $instagramFeed = [];

    foreach ($result as $index => $insta_post) {
      if ($index >= $this->limit) {
        break;
      }
      $picture_attributes = ['type' => 'instagram'];
      $picture_attributes["url"] = $insta_post->images->standard_resolution->url;
      $picture_attributes["link"] = $insta_post->link;
      $picture_attributes["text"] = wp_trim_words($insta_post->caption->text, 20);
      $picture_attributes["likes"] = $insta_post->likes->count;
      $picture_attributes["comments"] = $insta_post->comments->count;
      $instagramFeed[$insta_post->created_time] = $picture_attributes;
    }
    return $instagramFeed;
  }

  private function fetch()
  {
    $transient = get_transient($this->transientId);
    if (!empty($transient)) {
      $this->feed = $transient;
    } else {
      $this->feed = $this->fetchExternal();
      set_transient($this->transientId, $this->feed, $this->cacheTime);
    }
  }

  public function __construct()
  {
    $this->fetch();
  }
}