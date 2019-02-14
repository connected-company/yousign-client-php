<?php

namespace Connected\Yousign;

class Endpoint
{
    const USER = 'users';
    const USER_GROUP = 'user_groups';
    const PROCEDURE = 'procedures';
    const EXPORT = 'export';
    const FILE = 'files';
    const MEMBER = 'members';
    const FILE_OBJECT = 'file_objects';
    const CHECK_DOCUMENT = 'check_document';
    const OPERATION = 'operations';
    const AUTHENTICATION = 'authentications';
    const SIGNATURE_UI = 'signature_uis';
    const SERVER_STAMP = 'server_stamps';
    const CONSENT_PROCESSE = 'consent_processes';
    const CONSENT_PROCESS_VALUE = 'consent_process_values';

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';

    const ENDPOINTS = [
        self::USER,
        self::USER_GROUP,
        self::PROCEDURE,
        self::EXPORT,
        self::FILE,
        self::MEMBER,
        self::FILE_OBJECT,
        self::CHECK_DOCUMENT,
        self::OPERATION,
        self::AUTHENTICATION,
        self::SIGNATURE_UI,
        self::SERVER_STAMP,
        self::CONSENT_PROCESSE,
        self::CONSENT_PROCESS_VALUE,
    ];

    const ALLOWED_ENDPOINTS_METHODS = [
        self::USER => [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE],
        self::USER_GROUP => [self::METHOD_GET],
        self::PROCEDURE => [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE],
        self::EXPORT => [self::METHOD_GET],
        self::FILE => [self::METHOD_GET, self::METHOD_POST],
        self::MEMBER => [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE],
        self::FILE_OBJECT => [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE],
    ];

    /**
     * @return array
     */
    public static function getEndpoints()
    {
        return self::ENDPOINTS;
    }

    /**
     * @param string $endpoint
     * @return array
     */
    public static function getAllowedEndpoitMethods($endpoint)
    {
        if (in_array($endpoint, self::ENDPOINTS)) {
            return self::ALLOWED_ENDPOINTS_METHODS[$endpoint];
        }

        return null;
    }
}
