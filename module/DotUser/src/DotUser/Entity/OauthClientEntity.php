<?php
namespace DotUser\Entity;

class OauthClientEntity
{

    protected $clientId;

    protected $redirectUri;

    protected $grantTypes;

    protected $scope;

    protected $userId;

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function getGrantTypes()
    {
        return $this->grantTypes;
    }

    public function setGrantTypes($grantTypes)
    {
        $this->grantTypes = $grantTypes;
    }

    public function getScope()
    {
        return $this->scope;
    }

    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
}