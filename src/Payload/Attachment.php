<?php

namespace Slacker\Payload;

class Attachment implements \JsonSerializable, \ArrayAccess
{

    public $data = [];

    /** @var Field[] */
    public $fields = [];

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }

        return null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function __unset($name)
    {
        $this->offsetUnset($name);
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function __isset($name)
    {
        return $this->offsetExists($name);
    }

    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }

    public function jsonSerialize()
    {
        $data = $this->data;
        $data['fields'] = [];

        foreach ($this->fields as $field) {
            $data['fields'][] = $field->jsonSerialize();
        }

        return $data;
    }

}
