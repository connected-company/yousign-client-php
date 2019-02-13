<?php

namespace Connected\Yousign;

class Authentication
{
    /**
     * @var string
     */
    private $apikey;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * Authentication constructor.
     * @param $apikey
     * @param $username
     * @param $password
     */
    public function __construct($apikey, $username = null, $password = null)
    {
        $this->apikey = $apikey;

        if (null !== $username && null !== $password) {
            $this->username = $username;
            $this->password = $password;
        }
    }

    /**
     * @return mixed
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * @param mixed $apikey
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param $password
     * @return string
     */
    public static function buildHashedPassword($password)
    {
        return sha1(sha1($password).sha1($password));
    }
}
