<?php

namespace Slacker;

use GuzzleHttp\Client;
use Slacker\Payload\Attachment;
use Slacker\Payload\Payload;

class Slack
{
    /** @var SlackPoster */
    private $slackPoster;

    /** @var string */
    private $message;

    /** @var string */
    private $channel;

    /** @var string */
    private $username;

    /** @var Attachment */
    private $attachments = [];

    public function __construct(string $webhook, Client $client = null)
    {
        if (is_null($client)) {
            $client = new Client();
        }

        $this->slackPoster = new SlackPoster($client, $webhook);
    }

    public function newMessage(string $message): self
    {
        $this->clear();

        $this->message = $message;

        return $this;
    }

    public function channel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function username(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function attachment(Attachment $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    public function send(): int
    {
        $payload = new Payload();

        if (!is_null($this->channel)) {
            $payload->channel = $this->channel;
        }

        if (!is_null($this->username)) {
            $payload->username = $this->username;
        }

        $payload->text = $this->message;

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $payload->addAttachment($attachment);
            }
        }

        return $this->slackPoster->send($payload);
    }

    private function clear()
    {
        $this->message = null;
        $this->username = null;
        $this->channel = null;
        $this->attachments = [];
    }
}
