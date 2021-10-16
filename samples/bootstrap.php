<?php

require_once(__DIR__ . '/../vendor/autoload.php');

// Set these variables to test the examples
$mediakey = null;
$apiToken = null;
$messageNumber = null;
$messageName = null;

return [
  'apiToken' => $apiToken,
  'media' => __DIR__ . '/kolina_labs.png',
  'mediaKey' => $mediakey,
  'messages' => [
    [
      'number' => $messageNumber,
      'name' => $messageName,
      'body' => "Here is the customized welcome message for your *customer*\n" .
                "Here you can go to a new line of information. *cool* 😎!:\n\n" .
                "👍 *GitHub*: https://github.com/kolinalabs \n" .
                "👎 *Instagram*: https://www.instagram.com/kolina.labs",
      'mediaKey' => $mediakey,
      'mediaType' => 'image'
    ]
  ]
];
