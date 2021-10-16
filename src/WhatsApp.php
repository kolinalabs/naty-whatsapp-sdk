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

/**
 * This class represents the whatsapp instance on the api naty.
 * 
 * @author Claudinei Machado <claudinei@kolinalabs.com>
 */
class WhatsApp implements \JsonSerializable
{
  const STATUS_CONNECTED = 'CONNECTED';

  /**
   * @var string
   */
  private $id;

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $status;

  /**
   * @var \GuzzleHttp\Client
   */
  private $client;

  public function __construct(
    string $id,
    string $name,
    string $status,
    \GuzzleHttp\Client $client
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->status = $status;

    $this->client = $client;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getStatus()
  {
    return $this->status;
  }

  /**
   * @return boolean
   */
  public function isConnected()
  {
    return $this->status === self::STATUS_CONNECTED;
  }

  /**
   * Attempt connect whatsapp
   * 
   * @return array
   * 
   * @throws \Exception When request fails (Guzzle Exception)
   */
  public function connect()
  {
    $response = $this->client->patch(sprintf('whatsapps/start/%s', $this->id));

    $data = json_decode($response->getBody()->getContents(), true);

    return $data;
  }

  /**
   * Send messages
   * 
   * @param array $messages
   * @return array
   * 
   * @throws \Exception When request fails (Guzzle Exception)
   */
  public function send(array $messages = [])
  {
    $params = [
      'whatsappId' => $this->id,
      'messages' => $messages
    ];

    $response = $this->client->post('messages', ['json' => $params]);

    $data = json_decode($response->getBody()->getContents(), true);

    return $data;
  }

  public function jsonSerialize()
  {
      return $this->toArray();
  }

  public function toArray()
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'status' => $this->status
    ];
  }
}
