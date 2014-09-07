<?php

namespace Feedbee\PhpMessagingService\Message;

class BasicMessage implements MessageInterface
{
    /**
     * @var string[]
     */
    private $metadata;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @return string[]
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param $metadata string[]
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return \Feedbee\PhpMessagingService\Message\MessageInterface
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}