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
        $client = new Client();

        $guzzleClient = new GuzzleClient([
            'base_uri' => $this->environment->getHost(),
            'timeout' => $this->environment->getCurlTimeOut(),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->authentication->getToken(),
            ]
        ]);

        $client->setRestClient($guzzleClient);
        $client->setUri($this->environment->getHost());
        $client->setAppUri($this->environment->getAppHost());

        return $client;
    }
}
