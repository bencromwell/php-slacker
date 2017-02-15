<?php

namespace Slacker\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Slacker\Payload\Attachment;
use Slacker\Payload\Payload;
use Slacker\Slack;

class SlackTest extends TestCase
{
    public function testInstantiatesWithOnlyWebhook()
    {
        $slack = new Slack('some_webhook');
        $this->assertInstanceOf(Slack::class, $slack);
    }

    public function testNewMessageClears()
    {
        $slack = new Slack('some_webhook');
        $chainable = $slack->channel('foobar');

        $this->assertInstanceOf(Slack::class, $chainable);

        $property = new \ReflectionProperty($slack, 'channel');
        $property->setAccessible(true);
        $this->assertEquals('foobar', $property->getValue($slack));

        $chainable = $slack->username('slacker');

        $this->assertInstanceOf(Slack::class, $chainable);

        $property = new \ReflectionProperty($slack, 'username');
        $property->setAccessible(true);
        $this->assertEquals('slacker', $property->getValue($slack));

        $slack->attachment(Attachment::fromArray(['title' => 'Some Title']));
        $property = new \ReflectionProperty($slack, 'attachments');
        $property->setAccessible(true);
        $this->assertNotEmpty($property->getValue($slack));

        $slack->message('Foobar!');

        $property = new \ReflectionProperty($slack, 'channel');
        $property->setAccessible(true);
        $this->assertEquals('foobar', $property->getValue($slack));

        $property = new \ReflectionProperty($slack, 'username');
        $property->setAccessible(true);
        $this->assertEquals('slacker', $property->getValue($slack));

        $property = new \ReflectionProperty($slack, 'attachments');
        $property->setAccessible(true);
        $this->assertEmpty($property->getValue($slack));
    }

    public function testPayloadAsExpectedForABasicMessage()
    {
        $guzzle = \Mockery::mock(Client::class, function ($mock) {
            $payload = new Payload();
            $payload->text = 'Hello, World';

            $response = new Response();
            /** @var $mock Mock */
            $mock->shouldReceive('post')->withArgs(['some_webhook', [RequestOptions::JSON => $payload->jsonSerialize()]])->andReturn($response);
        });

        $slack = new Slack('some_webhook', $guzzle);
        $status = $slack->message('Hello, World')->send();

        $this->assertEquals(200, $status);
    }
}
