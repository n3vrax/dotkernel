<?php

namespace DotLimit\Factory;

use DotLimit\Listener\DefaultLimitWarningListener;
class DefaultLimitWarningListenerFactory
{
    public function __invoke($services)
    {
        return new DefaultLimitWarningListener();
    }
}