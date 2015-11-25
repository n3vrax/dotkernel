<?php

namespace DotUser\Oauth;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OAuth2ServerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $services
     * @return OAuth2\Server
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');
        $config = isset($config['zf-oauth2']) ? $config['zf-oauth2'] : [];
        return new OAuth2ServerInstanceFactory($config, $services);
    }
}
