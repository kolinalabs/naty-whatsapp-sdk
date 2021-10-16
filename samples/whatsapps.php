<?php
// List whatsapps

use KolinaLabs\Naty;
use KolinaLabs\WhatsApp;

$config = require_once(__DIR__ . '/bootstrap.php');

$naty = new Naty($config['apiToken']);

try {

  $whatsapps = $naty->whatsapps();

  /**
   * @var WhatsApp $whatsapp
   */
  foreach ($whatsapps as $whatsapp) {
    echo(
      sprintf(
        'Id: %s | Name: %s | Status: %s',
        $whatsapp->getId(),
        $whatsapp->getName(),
        $whatsapp->getStatus()
      ) . "\n"
    );
  }
} catch(\Exception $e) {
  die($e->getMessage());
}
