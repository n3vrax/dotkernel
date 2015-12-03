<?php

namespace RateLimit;

interface PackageNameProviderInterface
{
    public function getPackageName();
    
    public function getUniqueClientToken();
}