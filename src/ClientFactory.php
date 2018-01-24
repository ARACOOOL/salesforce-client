<?php

namespace SalesForce;

use GuzzleHttp\Client as GuzzleClient;
use SalesForce\Authentication\Authentication;

/**
 * Class ClientFactory
 * @package SalesForce
 */
class ClientFactory
{
    /**
     * @param Authentication $authentication
     * @return Client
     */
    public static function create(Authentication $authentication)
    {
        return new Client(new GuzzleClient(), $authentication);
    }
}