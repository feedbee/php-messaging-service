<?php

namespace Feedbee\PhpMessagingService\DataAdapter;

class InvalidDataFormatException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct("Invalid data format for SimpleJson adapter: {$message}");
    }
} 