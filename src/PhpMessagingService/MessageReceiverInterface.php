<?php

namespace Feedbee\PhpMessagingService;

interface MessageReceiverInterface
{
    /**
     * @param string $receiver
     * @param callable $onMessageReceivedCallback (\Feedbee\FoMessagingService\Message\MessageInterface $message): bool
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function receiveMessage($receiver, callable $onMessageReceivedCallback);

    /**
     * @param string $receiver
     * @param int $count
     * @param callable $onMessageReceivedCallback (\Feedbee\FoMessagingService\Message\MessageInterface $message): bool
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function receiveMessages($receiver, $count, callable $onMessageReceivedCallback);

    /**
     * @param string $receiver
     * @param callable $onMessageReceivedCallback (\Feedbee\FoMessagingService\Message\MessageInterface $message): bool
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function subscribe($receiver, callable $onMessageReceivedCallback);

    /**
     * @param string $receiver
     * @param callable
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function unsubscribe($receiver, callable $onMessageReceivedCallback);
}