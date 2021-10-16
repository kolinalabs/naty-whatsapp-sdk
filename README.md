![Naty](https://github.com/kolinalabs/naty-whatsapp-sdk/blob/main/samples/naty001.png)

# Naty WhatsApp PHP SDK

Naty WhatsApp PHP SDK is a library that facilitates the use of resources available in [API Naty](https://secretarianaty.com/).

- Get your connected (or disconnected) whatsapp numbers.
- Start a session to disconnected whatsapp number.
- Upload files, getting the mediaKey to send in messages.
- Send personalized messages to a contact list.

```php

use KolinaLabs\NatyApi;

$naty = new NatyApi('<your-naty-api-token>');

// Get whatsapp numbers with status
$whatsapps = $naty->whatsapps();

// Get specific whatsapp (eg: $whatsapps[0])
$whatsapp = current($whatsapps);

if (!$whatsapp) {
  die('No connection returned.');
}

if(!$whatsapp->isConnected()) {
  $status = $naty->connect($whatsapp);
}

$messages = [
  [
    'number' => '<whatsapp-number-here>',
    'name' => '<your contact name>',
    'body' => "Your custom message *Hello* 😎!\n" .
      "Text with line breaks is also *accepted*:\n\n" .
      "👍 *Instagram*: https://www.instagram.com/kolina.labs \n" .
      "👎 *Website*: https://kolinalabs.com",
    // 'mediaKey' => $mediaKey,
    // 'mediaType' => 'image'
  ],
  //... more messages here
];

// Send messages - Method 1
$result = $naty->messages($whatsapp, $messages);

// Send messages - Method 2
$result = $whatsapp->send($messages);
```

## For more info see [samples](https://github.com/kolinalabs/naty-whatsapp-sdk/tree/main/samples)
