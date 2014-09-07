<?php

namespace Feedbee\PhpMessagingService\Tests;

use Feedbee\PhpMessagingService\Message\BasicMessage;

abstract class BackendTestAbstract extends \PHPUnit_Framework_TestCase
{
    public function testSendAndReceive()
    {
        $message = $this->setupTestMessage();
        $backendInstance = $this->setupBackendInstance();

        $this->assertEmpty($backendInstance->receive('test-receiver'));
        $backendInstance->send('test-receiver', $message);
        $receivedMessage = $backendInstance->receive('test-receiver');

        $this->assertEquals($message->getBody(), $receivedMessage->getBody());
        $this->assertEquals($message->getMetaData(), $receivedMessage->getMetaData());

        $this->assertEmpty($backendInstance->receive('test-receiver')); // received earlier message must be removed from queue
        $this->assertEmpty($backendInstance->receive('test-non-exists-receiver'));
    }

    public function testSubscribe()
    {
        $message = $this->setupTestMessage();
        $backendInstance = $this->setupBackendInstance();

        $this->assertEmpty($backendInstance->receive('test-receiver'));
        $backendInstance->subscribe('test-receiver', function ($receivedMessage) use ($message) {
            /** @var \Feedbee\PhpMessagingService\Message\BasicMessage $receivedMessage */
            $this->assertEquals($message->getBody(), $receivedMessage->getBody());
            $this->assertEquals($message->getMetaData(), $receivedMessage->getMetaData());

            return true;
        });
        $backendInstance->send('test-receiver', $message);
        $this->assertEmpty($backendInstance->receive('test-non-exists-receiver'));
        // received in subscription earlier message must be removed from queue
        $this->assertEmpty($backendInstance->receive('test-receiver'));
    }

    public function testUnsubscribe()
    {
        $message = $this->setupTestMessage();
        $backendInstance = $this->setupBackendInstance();

        $this->assertEmpty($backendInstance->receive('test-receiver'));
        $fakeCallback = function () { return false; };
        $backendInstance->subscribe('test-receiver', $fakeCallback);
        $backendInstance->unsubscribe('test-receiver', $fakeCallback);
        $backendInstance->send('test-receiver', $message);
        $this->assertNotEmpty($backendInstance->receive('test-receiver'));
    }

    private function setupTestMessage()
    {
        $message = new BasicMessage;
        $message->setBody('Test Body');
        $message->setMetadata(['testKey' => 'testValue']);

        return $message;
    }

    /**
     * @return \Feedbee\PhpMessagingService\Backend\BackendInterface
     */
    abstract protected function setupBackendInstance();
}