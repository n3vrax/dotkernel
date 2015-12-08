<?php

namespace RateLimit\Factory;

use RateLimit\Listener\DefaultLimitExceededListener;
class DefaultLimitExceededListenerFactory
{
    public function __invoke($services)
    {
        return new DefaultLimitExceededListener();
    }
}