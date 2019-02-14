<?php

namespace Connected\Yousign;

class Authentication
{
    /**
     * @var string
     */
    private $token;

    /**
     * Authentication constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}
