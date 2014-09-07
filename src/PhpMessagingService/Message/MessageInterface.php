<?php

namespace Feedbee\PhpMessagingService\Message;

interface MessageInterface
{
    /**
     * @return string[]
     */
    public function getMetadata();

    /**
     * @param $metadata string[]
     */
    public function setMetadata(array $metadata);

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @param mixed $body
     * @return \Feedbee\PhpMessagingService\Message\MessageInterface
     */
    public function setBody($body);
}