<?php

namespace Feedbee\PhpMessagingService\Tests;

use Feedbee\PhpMessagingService\Backend\Variable;

require(__DIR__ . '/BackendTestAbstract.php');
class VariableTest extends BackendTestAbstract
{
    protected function setupBackendInstance()
    {
        return new Variable();
    }
}