<?php
// Connect specific whatsapp

use KolinaLabs\Naty;
use KolinaLabs\WhatsApp;

$config = require_once(__DIR__ . '/bootstrap.php');

$naty = new Naty($config['apiToken']);

try {
  $whatsapps = $naty->whatsapps();

  /**
   * @var WhatsApp $whatsapp
   */
  $whatsapp = current($whatsapps);

  if (!$whatsapp) {
    echo "No connection returned \n"; die;
  }

  if (!$whatsapp->isConnected()) {
    // Method 1 - via Naty
    // $status = $naty->connect($whatsapp);

    // Method 2 - via WhatsApp
    $status = $whatsapp->connect();

    echo $status['message'] . "\n";
  } else {
    echo sprintf('WhatsApp %s is already connected!', $whatsapp->getId()) . "\n";
  }
} catch(\Exception $e) {
  die($e->getMessage());
}

