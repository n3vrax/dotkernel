<?php

namespace RateLimit\Factory;

use RateLimit\Listener\DefaultLimitWarningListener;
class DefaultLimitWarningListenerFactory
{
    public function __invoke($services)
    {
        return new DefaultLimitWarningListener();
    }
}