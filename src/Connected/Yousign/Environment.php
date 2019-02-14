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

    const HOST_MAPPING = [
        self::DEMO => 'https://staging-api.yousign.com',
        self::PROD => 'https://api.yousign.com/users',
    ];

    /**
     * @var string
     */
    private $environment;

    /**
     * Environment constructor.
     * @param null $environment
     * @throws EnvironmentException
     */
    public function __construct($environment = null)
    {
        if (in_array($environment, static::HOSTS) === false) {
            throw new EnvironmentException($environment);
        }

        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return static::HOST_MAPPING[$this->environment];
    }
}
