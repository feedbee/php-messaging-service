<?php

namespace Feedbee\PhpMessagingService;

use Feedbee\PhpMessagingService\Message\MessageInterface;

class MessageSender implements MessagingServiceInterface
{
    /**
     * @var \Feedbee\PhpMessagingService\Backend\BackendInterface
     */
    private $backend;

    /**
     * @var \Feedbee\PhpMessagingService\DataAdapter\DataAdapterInterface
     */
    private $dataAdapter;

    public function __construct(Backend\BackendInterface $backend, DataAdapter\DataAdapterInterface $dataAdapter)
    {
        $this->setBackend($backend);
    }

    /**
     * @return \Feedbee\PhpMessagingService\Backend\BackendInterface
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * @param \Feedbee\PhpMessagingService\Backend\BackendInterface $backend
     */
    public function setBackend(Backend\BackendInterface $backend)
    {
        $this->backend = $backend;
    }

    /**
     * @return \Feedbee\PhpMessagingService\DataAdapter\DataAdapterInterface
     */
    public function getDataAdapter()
    {
        return $this->dataAdapter;
    }

    /**
     * @param $dataAdapter \Feedbee\PhpMessagingService\DataAdapter\DataAdapterInterface
     */
    public function setDataAdapter(DataAdapter\DataAdapterInterface $dataAdapter)
    {
        $this->dataAdapter = $dataAdapter;
    }

    /**
     * @param string $receiver
     * @param \Feedbee\PhpMessagingService\Message\MessageInterface $message
     * @throws \RuntimeException
     * @return \Feedbee\PhpMessagingService\MessageSenderInterface
     */
    public function sendMessage($receiver, MessageInterface $message)
    {
        $this->checkReceiver($receiver);

        $rawMessage = $this->dataAdapter->serialize($message);
        $this->getBackend()->send($receiver, $rawMessage);
    }

    private function checkReceiver($receiver)
    {
        if (strlen($receiver) < 1) {
            throw new \RuntimeException("Receiver must be non empty string, but `$receiver` given");
        }
    }

    /**
     * @param string $receiver
     * @param \Feedbee\PhpMessagingService\Message\MessageInterface[] $messages
     * @throws \RuntimeException
     * @return \Feedbee\PhpMessagingService\MessageSenderInterface
     */
    public function sendMessages($receiver, array $messages)
    {
        $this->checkReceiver($receiver);

        foreach ($messages as $message) {
            if (!($message instanceof MessageSenderInterface)) {
                $givenType = get_class($message);
                throw new \RuntimeException("All messages must be \\Feedbee\\PhpMessagingService\\MessageInterface, "
                    . "but {$givenType} instance given. Nothing sent");
            }
        }

        foreach ($messages as $message) {
            $this->sendMessage($receiver, $message);
        }

        return $this;
    }

    /**
     * @param string $receiver
     * @param callable $onMessageReceivedCallback (\Feedbee\FoMessagingService\Message\MessageInterface $message): bool
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function receiveMessage($receiver, callable $onMessageReceivedCallback)
    {
        $this->checkReceiver($receiver);

        $rawMessage = $this->getBackend()->receive($receiver);
        $message = $this->getDataAdapter()->unserialize($rawMessage);
        $onMessageReceivedCallback($message);

        return $this;
    }

    /**
     * @param string $receiver
     * @param int $count
     * @param callable $onMessageReceivedCallback (\Feedbee\FoMessagingService\Message\MessageInterface $message): bool
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function receiveMessages($receiver, $count, callable $onMessageReceivedCallback)
    {
        $this->checkReceiver($receiver);

        $received = 0;
        while ($received < $count) {
            $this->receiveMessage($receiver, $onMessageReceivedCallback);
            $received++;
        }
    }

    /**
     * @param string $receiver
     * @param callable $onMessageReceivedCallback (\Feedbee\FoMessagingService\Message\MessageInterface $message): bool
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function subscribe($receiver, callable $onMessageReceivedCallback)
    {
        $this->checkReceiver($receiver);
        $this->getBackend()->subscribe($receiver, function ($rawMessage) use ($onMessageReceivedCallback) {
            $message = $this->getDataAdapter()->unserialize($rawMessage);
            $onMessageReceivedCallback($message);
        });
    }

    /**
     * @param string $receiver
     * @param callable
     * @return \Feedbee\PhpMessagingService\MessageReceiverInterface
     */
    public function unsubscribe($receiver, callable $onMessageReceivedCallback)
    {
        throw new \Exception('Not implemented');
    }
}