<?php

namespace DotLimit\Factory;

use DotLimit\Listener\DefaultLimitExceededListener;
class DefaultLimitExceededListenerFactory
{
    public function __invoke($services)
    {
        return new DefaultLimitExceededListener();
    }
}