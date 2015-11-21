<?php

namespace DotUser\Authentication;

use ZF\OAuth2\Provider\UserId\UserIdProviderInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Stdlib\RequestInterface;
class UserIdProvider implements UserIdProviderInterface
{
    /**
     * @var ZendAuthenticationService
     */
    private $authenticationService;

    /**
     * @var string
     */
    private $userId = 'id';

    /**
     *  Set authentication service
     *
     * @param ZendAuthenticationService $service
     * @param array $config
     */
    public function __construct(AuthenticationService $service = null, $config = [])
    {
        $this->authenticationService = $service;

        if (isset($config['zf-oauth2']['user_id'])) {
            $this->userId = $config['zf-oauth2']['user_id'];
        }
    }

    /**
     * Use Zend\Authentication\AuthenticationService to fetch the identity.
     *
     * @param  RequestInterface $request
     * @return mixed
     */
    public function __invoke(RequestInterface $request)
    {
        if (empty($this->authenticationService)) {
            return null;
        }

        $identity = $this->authenticationService->getIdentity();

        if (is_object($identity)) {

            $method = "get" . ucfirst($this->userId);
            if (method_exists($identity, $method)) {
                return $identity->$method();
            }

            return null;
        }

        if (is_array($identity) && isset($identity[$this->userId])) {
            return $identity[$this->userId];
        }

        return null;
    }
}
