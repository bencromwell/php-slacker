<?php

namespace Slacker\Payload;

class Attachment implements \JsonSerializable
{

    public $fallback;
    public $color;

    /** @var Field[] */
    public $fields = array();

    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }

    public function jsonSerialize()
    {
        return array(
            'fallback' => $this->fallback,
            'color' => $this->color,
            'fields' => $this->fields,
        );
    }

}
