<?php

/*
 * This file is part of the KolinaLabs Naty WhatsApp Sdk package.
 *
 * (c) Claudinei Machado <claudinei@kolinalabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KolinaLabs;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

/**
 * This class abstracts the useful operations of the api naty.
 *
 * Usage:
 *
 *     $naty = new Naty('your-naty-api-token');
 *     $whatsapps = $naty->whatsapps();
 *     
 *     $whatsapp = current($whatsapps); // The first whatsapp (example)
 *     $whatsapp->send($messages)       // Send array messages
 * 
 * @author Claudinei Machado <claudinei@kolinalabs.com>
 */
class Naty
{
  const API_URL = 'https://api.naty.app/api/v1/';

  /**
   * @var string
   */
  private $apiToken;

  /**
   * @var Client
   */
  private $client;

  /**
   * @param string $apiToken
   */
  public function __construct($apiToken)
  {
    $this->apiToken = $apiToken;

    $this->client = new Client([
      'base_uri' => self::API_URL,
      'headers' => [
        'Authorization' => sprintf('Bearer %s', $this->apiToken)
      ]
    ]);
  }

  /**
   * @return array
   * 
   * @throws \Exception When request fails (Guzzle Exception)
   */
  public function whatsapps()
  {
    try {
      $response = $this->client->get('whatsapps');
      $items = json_decode($response->getBody()->getContents(), true);

      $whatsapps = [];
      foreach ($items as $data) {
        list($id, $name, $status) = array_values($data);
        array_push($whatsapps, new WhatsApp($id, $name, $status, $this->client));
      }

      return $whatsapps;
    } catch (\Exception $exception) {
      throw $exception;
    }
  }

  /**
   * @param string|resource $media <file path|stream resource>
   * @return array
   * 
   * @throws \Exception When request fails (Guzzle Exception)
   */
  public function medias($media)
  {
      try {
        $body = \is_string($media) ? Psr7\Utils::tryFopen($media, 'r') : $media;

        $response = $this->client->post('medias', [
          'multipart' => [
            [
              'name' => 'media',
              'contents' => $body
            ]
          ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        return $data;
      } catch (\Exception $exception) {
        throw $exception;
      }
  }

  /**
   * @param WhatsApp|string $whatsapp
   * @return array
   * 
   * @throws \Exception When request fails (Guzzle Exception)
   */
  public function connect(WhatsApp|string $whatsapp)
  {
    try {
      if ($whatsapp instanceof WhatsApp) {
        return $whatsapp->connect();
      }

      $response = $this->client->patch(sprintf('whatsapps/start/%s', $whatsapp));

      $data = json_decode($response->getBody()->getContents(), true);

      return $data;
    } catch (\Exception $exception) {
      throw $exception;
    }
  }

  /**
   * @param WhatsApp|string $whatsapp <WhatsApp instance|WhatsApp ID>
   * @param array $messages
   * @return array
   * 
   * @throws \Exception When request fails (Guzzle Exception)
   */
  public function send(WhatsApp|string $whatsapp, array $messages = [])
  {
      try {
        if ($whatsapp instanceof WhatsApp) {
          return $whatsapp->send($messages);
        }

        $params = [
          'whatsappId' => $whatsapp,
          'messages' => $messages
        ];

        $response = $this->client->post('messages', ['json' => $params]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
      } catch (\Exception $exception) {
        throw $exception;
      }
  }
}
