<?php

namespace Connected\Yousign\Exception;

class MethodNotAllowedException extends \Exception
{
    /**
     * @param string $endpoint
     * @param string $method
     */
    public function __construct($endpoint, $method)
    {
        parent::__construct(sprintf('The given method "%s" is not allowed on the endpoint "%s"', $method, $endpoint), 405);
    }
}
