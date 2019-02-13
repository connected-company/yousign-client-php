<?php

namespace Connected\Yousign\Exception;

class UnknownClientException extends \Exception
{
    /**
     * @param string $name
     */
    public function __construct($name) {
        parent::__construct(sprintf('The soap client "%s" does not exist', $name));
    }

}
