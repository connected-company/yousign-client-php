<?php

namespace Connected\Yousign;


class Services
{
    const AUTHENTICATION = 'AuthenticationWS';
    const COSIGNATURE = 'CosignWS';
    const ARCHIVE = 'ArchiveWS';

    /**
     * @return array
     */
    public static function listing()
    {
        return array(
            self::AUTHENTICATION,
            self::COSIGNATURE,
            self::ARCHIVE,
        );
    }
}
