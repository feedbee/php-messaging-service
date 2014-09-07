<?php

namespace Feedbee\PhpMessagingService\DataAdapter;

use Feedbee\PhpMessagingService\Message\BasicMessage;
use Feedbee\PhpMessagingService\Message\MessageInterface;

class SimpleJson implements DataAdapterInterface
{
    /**
     * @var callable
     */
    private $messageFabric;

    public function __construct(callable $messageFabric = null)
    {
        if (!is_null($messageFabric)) {
            $messageFabric = array($this, 'createMessageInstance');
        }
        $this->messageFabric = $messageFabric;
    }

    private function createMessageInstance(array $metadata)
    {
        if (isset($metadata['class-name'])) {
            if (!class_exists($metadata['class-name'])) {
                throw new \RuntimeException("Class `{$metadata['class-name']}` is not found");
            }
            return new $metadata['class-name'];
        }

        return new BasicMessage;
    }

    /**
     * @param \Feedbee\PhpMessagingService\Message\MessageInterface $message
     * @return mixed
     */
    public function serialize(MessageInterface $message)
    {
        $data = array(
            'metadata' => $message->getMetadata(),
            'body' => $message->getBody(),
        );

        return $data;
    }

    /**
     * @param $serializedData
     * @throws InvalidDataFormatException
     * @return \Feedbee\PhpMessagingService\Message\MessageInterface
     */
    public function unserialize($serializedData)
    {
        if (!is_array($serializedData)) {
            throw new InvalidDataFormatException('data is not array');
        }

        if (!isset($serializedData['metadata'])) {
            throw new InvalidDataFormatException('`metadata` key was not found');
        }

        if (!isset($serializedData['body'])) {
            throw new InvalidDataFormatException('`body` key was not found');
        }

        $messageFabric = $this->messageFabric;
        /** @var \Feedbee\PhpMessagingService\Message\MessageInterface $message */
        $message = $messageFabric($serializedData['metadata']);
        $message->setMetadata($serializedData['metadata']);
        $message->setBody($serializedData['body']);

        return $message;
    }
}