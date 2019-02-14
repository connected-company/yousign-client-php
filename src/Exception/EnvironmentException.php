<?php

namespace Connected\Yousign\Exception;

class EnvironmentException extends \Exception
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct(sprintf('The given environment "%s" does not exist, please check your configuration. ', $name));
    }
}
