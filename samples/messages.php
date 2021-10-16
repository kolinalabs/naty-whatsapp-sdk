<?php
// Send messages (with medias)

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
    $status = $whatsapp->connect();

    echo $status['message'] . "\n";
  }

  $result = $whatsapp->send($config['messages']);

  // Alternative methods
  // $result = $naty->messages($whatsapp->getId(), $config['messages']);
  // $result = $naty->messages($whatsapp, $config['messages']);

  echo $result['message'] . "\n";

} catch(\Exception $e) {
  die($e->getMessage());
}
