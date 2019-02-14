<?php

namespace Connected\Yousign;

use GuzzleHttp\Client as GuzzleClient;

class ClientFactory
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * ClientFactory constructor.
     * @param Environment $environment
     * @param Authentication|null $authentication
     */
    public function __construct(Environment $environment, Authentication $authentication = null)
    {
        $this->environment = $environment;
        $this->authentication = $authentication;
    }

    /**
     * @param array $options
     * @return Client
     */
    public function createClient($options = array())
    {
        $client = (new GuzzleClient([
            'base_uri' => $environment->getHost(),
            'timeout' => 2.0,
        ]))->setDefaultOption('headers', [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authentication->getToken(),
        ]);

        return $client;
    }
}
