<?php

namespace Connected\Yousign;

use Connected\Yousign\Exception\EnvironmentException;

class Environment
{
    const DEMO = 'demo';
    const PROD = 'prod';

    const HOSTS = [
        self::DEMO,
        self::PROD,
    ];

    const HOST_MAPPING_API = [
        self::DEMO => 'https://staging-api.yousign.com',
        self::PROD => 'https://api.yousign.com',
    ];

    const HOST_MAPPING_APP = [
        self::DEMO => 'https://staging-app.yousign.com',
        self::PROD => 'https://webapp.yousign.com',
    ];

    /**
     * @var string
     */
    private $environment;

    /**
     * @var int number de seconde de timeout pour le client guzzle
     */
    private $curlTimeOut;

    /**
     * Environment constructor.
     * @param null $environment
     * @param null $curlTimeOut
     * @throws EnvironmentException
     */
    public function __construct($environment = null, $curlTimeOut = 10.0)
    {
        if (in_array($environment, static::HOSTS) === false) {
            throw new EnvironmentException($environment);
        }

        $this->environment = $environment;
        $this->curlTimeOut = sprintf("%.1f", $curlTimeOut);
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return static::HOST_MAPPING_API[$this->environment];
    }

    /**
     * @return float
     */
    public function getCurlTimeOut()
    {
        return $this->curlTimeOut;
    }

    /**
     * @return string
     */
    public function getAppHost()
    {
        return static::HOST_MAPPING_APP[$this->environment];
    }
}
