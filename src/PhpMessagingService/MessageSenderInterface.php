<?php

namespace Feedbee\PhpMessagingService;

use Feedbee\PhpMessagingService\Message\MessageInterface;

interface MessageSenderInterface
{
    /**
     * @param string $receiver
     * @param \Feedbee\PhpMessagingService\Message\MessageInterface $message
     * @return \Feedbee\PhpMessagingService\MessageSenderInterface
     */
    public function sendMessage($receiver, MessageInterface $message);

    /**
     * @param string $receiver
     * @param \Feedbee\PhpMessagingService\Message\MessageInterface[] $messages
     * @return \Feedbee\PhpMessagingService\MessageSenderInterface
     */
    public function sendMessages($receiver, array $messages);
}