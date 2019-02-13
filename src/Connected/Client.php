<?php

namespace Connected\Yousign;
use Connected\Yousign\Exception\NotFoundServiceException;
use Connected\Yousign\Exception\UnknownClientException;


/**
 * Class Client
 *
 * @package Yousign
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
    /**
     * @var \SoapClient
     */
    private $last_client = null;

    /**
     * @var array
     */
    private $methods_mapping = array (
        // Authent
        'connect' => Services::AUTHENTICATION,

        // Cosignature
        'initCosign' => Services::COSIGNATURE,
        'getCosignedFilesFromDemand' => Services::COSIGNATURE,
        'getInfosFromCosignatureDemand' => Services::COSIGNATURE,
        'getListCosign' => Services::COSIGNATURE,
        'cancelCosignatureDemand' => Services::COSIGNATURE,
        'alertCosigners' => Services::COSIGNATURE,
        'isPDFSignable' => Services::COSIGNATURE,
        'updateCosigner' => Services::COSIGNATURE,

        // Archivage
        'archive' => Services::ARCHIVE,
        'getArchive' => Services::ARCHIVE,
        'getCompleteArchive' => Services::ARCHIVE,
    );

    /**
     * @var array
     */
    private $clients = array();

    /**
     * @param $name
     * @param $arguments
     * @return \stdClass
     * @throws NotFoundServiceException
     * @throws UnknownClientException
     */
    public function __call($name, $arguments) {
        if(!isset($this->methods_mapping[$name])) {
            throw new NotFoundServiceException($name);
        }

        $service = $this->methods_mapping[$name];
        $client = $this->getSoapClient($service);
        if(!($client instanceof \SoapClient)) {
            throw new UnknownClientException($name);
        }

        $this->last_client = $client;

        return $client->__call($name, $arguments)->return;
    }

    /**
     * @param $name
     * @param \SoapClient $client
     * @return $this
     * @throws \RuntimeException
     */
    public function addSoapClient($name, \SoapClient $client) {
        if(empty($name)) {
            throw new \RuntimeException('Please given name to your Soap client');
        }

        $this->clients[$name] = $client;

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function removeSoapClient($name) {
        if(isset($this->clients[$name])) {
            unset($this->clients[$name]);
        }

        return $this;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getSoapClient($name) {
        return isset($this->clients[$name]) ?
            $this->clients[$name] : null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasSoapClient($name) {
        return $this->getSoapClient($name) !== null;
    }

    /**
     * @return \SoapClient
     */
    public function getLastClient() {
        return $this->last_client;
    }
}
