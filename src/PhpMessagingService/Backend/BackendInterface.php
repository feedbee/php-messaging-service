<?php

namespace Feedbee\PhpMessagingService\Backend;

interface BackendInterface
{
    /**
     * @param string $receiver
     * @param $message
     * @return void
     */
    public function send($receiver, $message);

    /**
     * @param string $receiver
     * @return mixed
     */
    public function receive($receiver);

    /**
     * @param string $receiver
     * @param callable $callback
     * @return void
     */
    public function subscribe($receiver, callable $callback);

    /**
     * @param string $receiver
     * @param callable $callback
     * @return void
     */
    public function unsubscribe($receiver, callable $callback);
}