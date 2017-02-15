<?php

namespace Slacker\Payload;

/**
 * @property string fallback    e.g. Required plain-text summary of the attachment
 * @property string color       e.g. #36a64f
 * @property string pretext     e.g. Optional text that appears above the attachment block
 * @property string author_name e.g. Bobby Tables
 * @property string author_link e.g. http://flickr.com/bobby/
 * @property string author_icon e.g. http://flickr.com/icons/bobby.jpg
 * @property string title       e.g. Slack API Documentation
 * @property string title_link  e.g. https://api.slack.com/
 * @property string text        e.g. Optional text that appears within the attachment
 * @property string image_url   e.g. http://my-website.com/path/to/image.jpg
 * @property string thumb_url   e.g. http://example.com/path/to/thumb.png
 * @property string footer      e.g. Slack API
 * @property string footer_icon e.g. https://platform.slack-edge.com/img/default_application_icon.png
 * @property int    ts          e.g. timestamp 123456789
 */
class Attachment implements \JsonSerializable, \ArrayAccess
{
    public $data = [];

    /** @var Field[] */
    public $fields = [];

    public static function fromArray(array $parameters)
    {
        $attachment = new self;

        foreach ($parameters as $k => $v) {
            $attachment->offsetSet($k, $v);
        }

        return $attachment;
    }

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
