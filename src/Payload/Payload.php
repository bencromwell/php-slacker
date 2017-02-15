<?php

namespace Slacker\Payload;

class Payload implements \JsonSerializable
{

    public $username;
    public $channel;
    public $text;

    /** @var Attachment[] */
    public $attachments = [];

    public function addAttachment(Attachment $attachment)
    {
        $this->attachments[] = $attachment;
    }

    public function jsonSerialize()
    {
        $data = [
            'username' => $this->username,
            'channel' => $this->channel,
            'text' => $this->text,
            'attachments' => [],
        ];

        foreach ($this->attachments as $attachment) {
            $data['attachments'][] = $attachment->jsonSerialize();
        }

        return $data;
    }

}
