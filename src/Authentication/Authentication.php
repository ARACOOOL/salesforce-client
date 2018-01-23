<?php

namespace SalesForce\Authentication;
use Assert\Assertion;

/**
 * Interface Authentication
 * @package SalesForce\Authentication
 */
abstract class Authentication
{
    const SANDBOX_HOST = 'https://test.salesforce.com';
    const LIVE_HOST = 'https://login.salesforce.com';

    /**
     * @var string
     */
    protected $host;

    /**
     * Authentication constructor.
     * @param string $host
     * @throws \Assert\AssertionFailedException
     */
    public function __construct($host)
    {
        Assertion::url($host);
        $this->host = $host;
    }

    /**
     * @return string
     */
    abstract public function getUrl();

    /**
     * @return array
     */
    abstract public function getCredentials();
}