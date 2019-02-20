<?php

namespace Connected\Yousign\Exception;

class NotFoundServiceException extends \Exception
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct(sprintf('The called method "%s" does not exist', $name));
    }
}
