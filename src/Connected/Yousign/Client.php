<?php

namespace Connected\Yousign;

use Connected\Yousign\Exception\NotAllowedMethodException;
use Connected\Yousign\Exception\NotFoundServiceException;
use Connected\Yousign\Exception\UnknownClientException;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Client
 *
 * @package Yousign
 *
 * @method getUsers
 * @method getUser
 * @method updateUser
 * @method getProcedures
 * @method getProcedure
 * @method newProcedure
 * @method updateProcedure
 * @method newFile
 * @method newMember
 * @method newFileObject
 */
class Client
{
    const RESPONSE_OK = [200, 201, 202, 204];
    const SIGN_MEMBER_URI = '/procedure/sign?members=';

    const METHODS = [
        'getUsers' => [
            'endpoint' => Endpoint::USER,
            'verb' => Endpoint::VERB_GET,
            'params' => null,
            'suffix' => null
        ],
        'getUser' => [
            'endpoint' => Endpoint::USER,
            'verb' => Endpoint::VERB_GET,
            'params' => ['id'],
            'suffix' => '/{id}'
        ],
        'updateUser' => [
            'endpoint' => Endpoint::USER,
            'verb' => Endpoint::VERB_PUT,
            'params' => ['id'],
            'suffix' => '/{id}'
        ],
        'getProcedures' => [
            'endpoint' => Endpoint::PROCEDURE,
            'verb' => Endpoint::VERB_GET,
            'params' => null,
            'suffix' => null
        ],
        'getProcedure' => [
            'endpoint' => Endpoint::PROCEDURE,
            'verb' => Endpoint::VERB_GET,
            'params' => ['id'],
            'suffix' => '/{id}'
        ],
        'newProcedure' => [
            'endpoint' => Endpoint::PROCEDURE,
            'verb' => Endpoint::VERB_POST,
            'params' => null,
            'suffix' => null
        ],
        'updateProcedure' => [
            'endpoint' => Endpoint::PROCEDURE,
            'verb' => Endpoint::VERB_PUT,
            'params' => ['id'],
            'suffix' => '/{id}'
        ],
        'deleteProcedure' => [
            'endpoint' => Endpoint::PROCEDURE,
            'verb' => Endpoint::VERB_DELETE,
            'params' => ['id'],
            'suffix' => '/{id}'
        ],
        'newFile' => [
            'endpoint' => Endpoint::FILE,
            'verb' => Endpoint::VERB_POST,
            'params' => null,
            'suffix' => null
        ],
        'newMember' => [
            'endpoint' => Endpoint::MEMBER,
            'verb' => Endpoint::VERB_POST,
            'params' => null,
            'suffix' => null
        ],
        'newFileObject' => [
            'endpoint' => Endpoint::FILE_OBJECT,
            'verb' => Endpoint::VERB_POST,
            'params' => null,
            'suffix' => null
        ],
    ];

    /**
     * @var GuzzleClient
     */
    protected $restClient;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $appUri;

    /**
     * @param $method The method to call
     * @param $arguments The arguments (body, routeParams)
     * @return string Json response
     * @throws NotFoundServiceException
     * @throws UnknownClientException
     * @throws NotAllowedMethodException
     */
    public function __call($method, $arguments)
    {
        $body = $arguments[0] ?? null;
        $body = $body ? json_encode($body) : null;
        $routeParams = $arguments[1] ?? null;

        if (!array_key_exists($method, static::METHODS)) {
            throw new NotFoundServiceException($method);
        }

        $restClient = $this->getRestClient();
        if (($restClient instanceof GuzzleClient) === false) {
            throw new UnknownClientException($method);
        }

        $method = static::METHODS[$method];
        $verb = $method['verb'];
        $endpoint = $method['endpoint'];

        // Check if method is allowed on the given endpoint
        if (Endpoint::isEndpointVerbAllowed($endpoint, $verb) === false) {
            throw new NotAllowedMethodException($endpoint, $method);
        }

        // Check if body is given in case of POST or PUT request
        if (($verb === Endpoint::VERB_POST || $verb === Endpoint::VERB_PUT) && is_null($body)) {
            throw new \Exception(sprintf('Body cannot be null when using verb %s', $verb), 500);
        }

        // Check params number and name
        $methodParams = $method['params'];

        if ($routeParams !== null) {
            if (count($routeParams) !== count($methodParams)) {
                throw new \Exception('Invalid parameter number', 500);
            }

            foreach ($routeParams as $key => $routeParam) {
                if (in_array($key, $methodParams) === false) {
                    throw new \Exception('Invalid param', 500);
                }
            }
        }

        // Building URI
        $uri = $method['endpoint'];
        $uri.= $method['suffix'];

        // URI param binding
        if ($methodParams) {
            foreach ($method['params'] as $key => $param) {
                $uri = str_replace('{'.$param.'}', $routeParams[$param], $uri);
            }
        }

        $response = $restClient->request($verb, $uri, ['body' => $body]);
        if (in_array($response->getStatusCode(), static::RESPONSE_OK)) {
            $content = json_decode($response->getBody()->getContents(), true);
        } else {
            throw new \Exception('Error Processing Request', 500);
        }

        return $content;
    }

    /**
     * @return GuzzleClient
     */
    public function getRestClient()
    {
        return $this->restClient;
    }

    /**
     * @param GuzzleClient $restClient
     * @return self
     */
    public function setRestClient(GuzzleClient $restClient)
    {
        $this->restClient = $restClient;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string
     * @return self
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppUri()
    {
        return $this->appUri;
    }

    /**
     * @param string
     * @return self
     */
    public function setAppUri($appUri)
    {
        $this->appUri = $appUri;

        return $this;
    }

    /**
     * @return string
     */
    public function getMemberSignUri($param)
    {
        return $this->getAppUri() . self::SIGN_MEMBER_URI . $param;
    }
}
