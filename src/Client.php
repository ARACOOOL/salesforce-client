<?php

namespace SalesForce;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use SalesForce\Authentication\Authentication;

/**
 * Class Client
 * @package SalesForce
 */
class Client
{
    const API_VERSION = 'v42.0';

    /**
     * @var Authentication
     */
    private $authentication;
    /**
     * @var GuzzleClient
     */
    private $client;
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $instanceUrl;

    /**
     * Client constructor.
     * @param GuzzleClient   $client
     * @param Authentication $authentication
     */
    public function __construct(GuzzleClient $client, Authentication $authentication)
    {
        $this->client = $client;
        $this->authentication = $authentication;
    }

    /**
     * @param string $query
     * @return \stdClass
     */
    public function get($query)
    {
        $this->checkAuthentication();

        try {
            $response = $this->client->get($this->getBaseEndpoint() . $query, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token
                ]
            ]);
        } catch (RequestException $exception) {
            throw new ClientException('Could not make a request: ' . $exception->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $endpoint
     * @param array  $params
     * @return \stdClass
     */
    public function create($endpoint, array $params)
    {
        $this->checkAuthentication();

        try {
            $response = $this->client->post($this->getBaseEndpoint() . $endpoint, [
                'json'    => $params,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token
                ]
            ]);
        } catch (RequestException $exception) {
            throw new ClientException('Could not make a request: ' . $exception->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $endpoint
     * @param array  $params
     * @return \stdClass
     */
    public function update($endpoint, array $params)
    {
        $this->checkAuthentication();

        try {
            $response = $this->client->patch($this->getBaseEndpoint() . $endpoint, [
                'json'    => $params,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token
                ]
            ]);
        } catch (RequestException $exception) {
            throw new ClientException('Could not make a request: ' . $exception->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $endpoint
     * @return \stdClass
     */
    public function delete($endpoint)
    {
        $this->checkAuthentication();

        try {
            $response = $this->client->delete($this->getBaseEndpoint() . $endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token
                ]
            ]);
        } catch (RequestException $exception) {
            throw new ClientException('Could not make a request: ' . $exception->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     *
     */
    private function checkAuthentication()
    {
        if (is_null($this->token) || is_null($this->instanceUrl)) {
            try {
                $response = $this->client->post($this->authentication->getUrl(), [
                    'form_params' => $this->authentication->getCredentials()
                ]);
            } catch (RequestException $exception) {
                throw new ClientException('Could not get a token: ' . $exception->getMessage());
            }

            $response = json_decode($response->getBody()->getContents());
            $this->token = $response->access_token;
            $this->instanceUrl = $response->instance_url;
        }
    }

    /**
     * @return string
     */
    private function getBaseEndpoint()
    {
        return sprintf('%s/services/data/%s', $this->instanceUrl, self::API_VERSION);
    }
}