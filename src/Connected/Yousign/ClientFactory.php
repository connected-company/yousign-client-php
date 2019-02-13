<?php

namespace Connected\Yousign;

class ClientFactory
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * ClientFactory constructor.
     * @param Environment $environment
     * @param Authentication|null $authentication
     */
    public function __construct(Environment $environment, Authentication $authentication = null)
    {
        $this->environment = $environment;
        $this->authentication = $authentication;
    }

    /**
     * @param array $options
     * @return Client
     */
    public function createClient($options = array())
    {
        $client = new Client();
        foreach(Services::listing() as $service) {
            $wsdl = sprintf('%s/%s/%s?wsdl', $this->environment->getHost(), $service, $service);
            $soapClient = new \SoapClient($wsdl, $options);

            $header = new \SoapHeader('http://www.yousign.com', 'Auth', (object)(array)$this->authentication);
            $soapClient->__setSoapHeaders($header);

            $client->addSoapClient($service, $soapClient);
        }

        return $client;
    }
}
