<?php

namespace DotUser\Oauth;

use OAuth2\OpenID\Controller\AuthorizeController;
use OAuth2\Storage\ClientInterface;
use OAuth2\OpenID\Storage\UserClaimsInterface;
use OAuth2\Storage\ScopeInterface;

class AuthorizeController extends AuthorizeController
{
    protected $userClaimsStorage;
    
    public function __construct(ClientInterface $clientStorage, UserClaimsInterface $userClaimsStorage , array $responseTypes = array(), array $config = array(), ScopeInterface $scopeUtil = null)
    {
        parent::__construct($clientStorage, $responseTypes, $config, $scopeUtil );
        $this->userClaimsStorage = $userClaimsStorage;
    }
    
    protected function buildAuthorizeParameters($request, $response, $user_id)
    {
        if (!$params = parent::buildAuthorizeParameters($request, $response, $user_id)) {
            return;
        }
    
        // Generate an id token if needed.
        if ($this->needsIdToken($this->getScope()) && $this->getResponseType() == self::RESPONSE_TYPE_AUTHORIZATION_CODE) {
            //get user claims and insert them into the token
            $userClaims = $this->userClaimsStorage->getUserClaims($user_id, $params['scope']);
            
            $params['id_token'] = $this->responseTypes['id_token']->createIdToken($this->getClientId(), $user_id, $this->nonce, $userClaims);
        }
    
        // add the nonce to return with the redirect URI
        $params['nonce'] = $this->nonce;
    
        return $params;
    }
}