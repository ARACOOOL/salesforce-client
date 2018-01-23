<?php

namespace SalesForce\Authentication;

/**
 * Class PasswordAuthentication
 * @package Neat\Salesforce\Authentication
 */
class PasswordAuthentication extends Authentication
{
    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $clientSecret;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    /**
     * PasswordAuthentication constructor.
     * @param        $host
     * @param string $clientId
     * @param string $clientSecret
     * @param string $username
     * @param string $password
     * @throws \Assert\AssertionFailedException
     */
    public function __construct($host, $clientId, $clientSecret, $username, $password)
    {
        parent::__construct($host);

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->host . '/services/oauth2/token';
    }

    /**
     * @return array
     */
    public function getCredentials()
    {
        return [
            'grant_type'    => 'password',
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username'      => $this->username,
            'password'      => $this->password
        ];
    }
}