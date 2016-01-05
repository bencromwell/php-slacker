# php-slacker
A quick Slack notifier for PHP

## Example usage

```
<?php

require __DIR__ . '/vendor/autoload.php';

$config = require(__DIR__ . '/slack-config.php');

// general setup
$slackPoster = new \Slacker\SlackPoster(
    new \GuzzleHttp\Client(),
    $config['hookUri']
);

$payload = new \Slacker\Payload\Payload();
$payload->username = $config['username'];
$payload->channel = $config['channel'];

// specific message setup
$payload->text = 'General Message Text';

$attachment = new \Slacker\Payload\Attachment();
$attachment->color = 'good';
$attachment->fallback = 'some fallback message';

$field = new \Slacker\Payload\Field();
$field->short = 'Field Short Message';
$field->title = 'Field Title';
$field->value = 'Field Value';
$attachment->addField($field);

$field = new \Slacker\Payload\Field();
$field->short = 'Field Short Message 2';
$field->title = 'Field Title 2';
$field->value = 'Field Value 2';
$attachment->addField($field);

$field = new \Slacker\Payload\Field();
$field->short = 'Field Short Message 3';
$field->title = 'Field Title 3';
$field->value = 'Field Value 3';
$attachment->addField($field);

$payload->addAttachment($attachment);

// send the message
$slackPoster->send($payload);
```
