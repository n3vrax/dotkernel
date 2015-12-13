<?php

namespace DotLimit;

interface PackageNameProviderInterface
{
    public function getPackageName();
    
    public function getUniqueClientToken();
}