<?php

namespace Slacker\Payload;

class Field implements \JsonSerializable
{

    public $title;
    public $value;
    public $short;

    public function jsonSerialize()
    {
        return array(
            'title' => $this->title,
            'value' => $this->value,
            'short' => $this->short,
        );
    }

}
