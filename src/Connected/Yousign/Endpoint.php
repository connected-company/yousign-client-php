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

    const VERB_GET = 'GET';
    const VERB_POST = 'POST';
    const VERB_PUT = 'PUT';
    const VERB_PATCH = 'PATCH';
    const VERB_DELETE = 'DELETE';

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

    const ALLOWED_ENDPOINTS_VERBS = [
        self::USER => [self::VERB_GET, self::VERB_POST, self::VERB_PUT, self::VERB_DELETE],
        self::USER_GROUP => [self::VERB_GET],
        self::PROCEDURE => [self::VERB_GET, self::VERB_POST, self::VERB_PUT, self::VERB_DELETE],
        self::EXPORT => [self::VERB_GET],
        self::FILE => [self::VERB_GET, self::VERB_POST],
        self::MEMBER => [self::VERB_GET, self::VERB_POST, self::VERB_PUT, self::VERB_DELETE],
        self::FILE_OBJECT => [self::VERB_GET, self::VERB_POST, self::VERB_PUT, self::VERB_DELETE],
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
    public static function getAllowedEndpoitVerbs($endpoint)
    {
        if (in_array($endpoint, self::ENDPOINTS)) {
            return self::ALLOWED_ENDPOINTS_VERBS[$endpoint];
        }

        return null;
    }

    /**
     * @param string $endpoint
     * @return array
     */
    public static function isEndpointVerbAllowed($endpoint, $verb)
    {
        return in_array($verb, static::getAllowedEndpoitVerbs($endpoint));
    }
}
