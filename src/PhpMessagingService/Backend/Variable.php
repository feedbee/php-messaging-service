<?php

namespace Feedbee\PhpMessagingService\Backend;

class Variable implements BackendInterface
{
    /**
     * @var array
     */
    private $queue = array();

    private $subscriptions = array();

    /**
     * @param string $receiver
     * @param $message
     * @return void
     */
    public function send($receiver, $message)
    {
        if (!isset($this->queue[$receiver])) {
            $this->queue[$receiver] = array();
        }

        $newMessage = clone $message;

        if (isset($this->subscriptions[$receiver]) and count($this->subscriptions[$receiver]) > 0) {
            $key = array_keys($this->subscriptions[$receiver])[0];
            $this->subscriptions[$receiver][$key]($newMessage);
            return;
        }

        $this->queue[$receiver][] = clone $newMessage;
    }

    /**
     * @param string $receiver
     * @return mixed
     */
    public function receive($receiver)
    {
        if (!isset($this->queue[$receiver])) {
            return null;
        }

        return array_shift($this->queue[$receiver]);
    }

    /**
     * @param string $receiver
     * @param callable $callback
     * @return void
     */
    public function subscribe($receiver, callable $callback)
    {
        if (!isset($this->subscriptions[$receiver])) {
            $this->subscriptions[$receiver] = array();
        }

        $this->subscriptions[$receiver][] = $callback;
    }

    /**
     * @param string $receiver
     * @param callable $callback
     * @return void
     */
    public function unsubscribe($receiver, callable $callback)
    {
        if (isset($this->subscriptions[$receiver])) {
            $key = array_search($callback, $this->subscriptions[$receiver]);
            if (false !==  $key) {
                unset($this->subscriptions[$receiver][$key]);
            }
        }
    }
} 