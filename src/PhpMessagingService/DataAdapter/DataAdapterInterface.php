<?php

namespace Feedbee\PhpMessagingService\DataAdapter;

use Feedbee\PhpMessagingService\Message\MessageInterface;

interface DataAdapterInterface
{
    /**
     * @param \Feedbee\PhpMessagingService\Message\MessageInterface $message
     * @return mixed
     */
    public function serialize(MessageInterface $message);

    /**
     * @param $serializedData
     * @return \Feedbee\PhpMessagingService\Message\MessageInterface
     */
    public function unserialize($serializedData);
}