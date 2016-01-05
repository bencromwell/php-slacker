<?php

namespace Slacker\Payload;

class Payload implements \JsonSerializable
{

    public $username;
    public $channel;
    public $text;

    /** @var Attachment[] */
    public $attachments = array();

    public function addAttachment(Attachment $attachment)
    {
        $this->attachments[] = $attachment;
    }

    public function jsonSerialize()
    {
        return array(
            'username' => $this->username,
            'channel' => $this->channel,
            'text' => $this->text,
            'attachments' => $this->attachments,
        );
    }

}
