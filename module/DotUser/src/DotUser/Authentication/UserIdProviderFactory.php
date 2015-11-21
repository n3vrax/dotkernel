<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace DotUser\Authentication;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Authentication\UserIdProvider;

class UserIdProviderFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return AuthenticationService
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');

        if ($services->has('Zend\Authentication\AuthenticationService')) {
            return new UserIdProvider(
                $services->get('Zend\Authentication\AuthenticationService'),
                $config
            );
        }

        return new UserIdProvider(null, $config);
    }
}
