<?php
// Upload file and get mediaKey

use KolinaLabs\Naty;
// use GuzzleHttp\Psr7; // To the alternative method

$config = require_once(__DIR__ . '/bootstrap.php');

$naty = new Naty($config['apiToken']);

try {
  $uploaded = $naty->medias($config['media']);

  // Alternative method (with resource stream)
  // $media = Psr7\Utils::tryFopen($config['media'], 'r');
  // $uploaded = $naty->medias($media);

  echo sprintf('mediaKey: %s', $uploaded['mediaKey']) . "\n";
} catch(\Exception $e) {
  die($e->getMessage());
}
