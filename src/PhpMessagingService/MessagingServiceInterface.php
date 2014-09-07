<?php

namespace Feedbee\PhpMessagingService;

interface MessagingServiceInterface extends MessageReceiverInterface, MessageSenderInterface
{
    /**
     * @param \Feedbee\PhpMessagingService\Backend\BackendInterface $backend
     * @param \Feedbee\PhpMessagingService\DataAdapter\DataAdapterInterface $dataAdapter
     */
    public function __construct(Backend\BackendInterface $backend, DataAdapter\DataAdapterInterface $dataAdapter);

    /**
     * @return \Feedbee\PhpMessagingService\Backend\BackendInterface
     */
    public function getBackend();

    /**
     * @param $backend \Feedbee\PhpMessagingService\Backend\BackendInterface
     */
    public function setBackend(Backend\BackendInterface $backend);

    /**
     * @return \Feedbee\PhpMessagingService\DataAdapter\DataAdapterInterface
     */
    public function getDataAdapter();

    /**
     * @param $dataAdapter \Feedbee\PhpMessagingService\DataAdapter\DataAdapterInterface
     */
    public function setDataAdapter(DataAdapter\DataAdapterInterface $dataAdapter);
}