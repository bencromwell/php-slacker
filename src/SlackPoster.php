<?php

namespace Slacker;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Slacker\Payload\Payload;

class SlackPoster
{

    /** @var Client */
    private $client;

    /** @var string */
    private $uri;

    /**
     * @param Client $client
     * @param string $uri
     */
    public function __construct(Client $client, $uri)
    {
        $this->client = $client;
        $this->uri = $uri;
    }

    /**
     * @param Payload $payload
     * @return int
     */
    public function send(Payload $payload)
    {
        $post = $this->client->post($this->uri, [RequestOptions::JSON => $payload->jsonSerialize()]);

        return $post->getStatusCode();
    }

}
