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
 *
 * @method connect
 * @method initCosign
 * @method getCosignedFilesFromDemand
 * @method getInfosFromCosignatureDemand
 * @method getListCosign
 * @method cancelCosignatureDemand
 * @method alertCosigners
 * @method isPDFSignable
 * @method updateCosigner
 * @method archive
 * @method getArchive
 * @method getCompleteArchive
 */
class Client
{
    const RESPONSE_OK = [
        200, 201
    ];

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
    ];

    const SIGN_MEMBER_URI = '/procedure/sign?members=';

    protected $restClient;

    protected $uri;
    protected $appUri;

    /**
     * @var array
     */
    private $clients = array();

    /**
     * @param $method
     * @param $arguments
     * @return \stdClass
     * @throws NotFoundServiceException
     * @throws UnknownClientException
     */
    public function __call($method, $arguments)
    {
        $body = $arguments[0] ?? null;
        $body = $body ? json_encode($body) : null;
        $routeParams = $arguments[1] ?? null;

        // dump($routeParams);
        // dump($body);

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

        if (Endpoint::isEndpointVerbAllowed($endpoint, $verb) === false) {
            throw new NotAllowedMethodException($endpoint, $method);
        }


        // Check du body requis sur un POST ou PUT
        if (($verb === Endpoint::VERB_POST || $verb === Endpoint::VERB_PUT) && is_null($body)) {
            throw new \Exception(sprintf('Body cannot be null when using verb %s', $verb), 500);
        }


        // Vérification des arguments
        $methodParams = $method['params'];

        // if ($routeParams !== null && (count($routeParams) !== count($methodParams))) {
        //     throw new \Exception('Invalid parameter number', 500);
        // }

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


        // Building URI with params binding
        $uri = $method['endpoint'];
        $uri.= $method['suffix'];
        // $uri = $method['endpoint'] . $method['suffix'];
        if ($methodParams) {
            foreach ($method['params'] as $key => $param) {
                $uri = str_replace('{'.$param.'}', $routeParams[$param], $uri);
            }
        }
        // dump($uri);die;
        $response = $restClient->request($verb, $uri, ['body' => $body]);
        if (in_array($response->getStatusCode(), static::RESPONSE_OK)) {
            $content = json_decode($response->getBody()->getContents(), true);
            // dd($response->getBody()->getContents());
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

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function getAppUri()
    {
        return $this->appUri;
    }

    public function setAppUri($appUri)
    {
        $this->appUri = $appUri;

        return $this;
    }

    public function getMemberSignUri($param)
    {
        return $this->getAppUri() . self::SIGN_MEMBER_URI . $param;
    }
}
