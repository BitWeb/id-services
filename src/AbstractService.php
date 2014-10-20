<?php

namespace BitWeb\IdServices;

use BitWeb\IdServices\Exception\ServiceException;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\Soap\Client;

class AbstractService
{
    /**
     * WSDL URL
     *
     * @var string
     */
    protected $wsdl;

    /**
     * @var array
     */
    protected $classMap = [];

    /**
     * @var Client
     */
    protected $soap;

    /**
     * @var Logger
     */
    protected $logger;

    public function setWsdl($wsdl = null)
    {
        if ($wsdl === null) {
            $wsdl = 'https://www.openxades.org:9443/?wsdl';
        }

        $this->wsdl = $wsdl;

        return $this;
    }

    public function getWsdl()
    {
        return $this->wsdl;
    }

    public function initSoap()
    {
        if (null === $this->wsdl) {
            throw new ServiceException('No WSDL URL provided.');
        }

        $options = [
            'soapVersion' => SOAP_1_1,
            'classMap' => $this->classMap
        ];

        // workaround for PHP5.6, needed for Travis tests to pass.
        if (version_compare(PHP_VERSION, '5.6.0') !== -1) {
            $options['stream_context'] = stream_context_create(
                [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                    ]
                ]
            );
        }

        $this->soap = new Client($this->wsdl, $options);

        return $this;
    }

    /**
     * @param \SoapFault $e
     * @return ServiceException
     */
    protected function soapError(\SoapFault $e)
    {
        return ServiceException::soapFault($e);
    }

    public function enableLogging($fileName)
    {
        $this->logger = new Logger();
        $this->logger->addWriter(new Stream($fileName, 'a+'));

        return $this;
    }

    protected function log($priority, $message)
    {
        if ($this->logger !== null) {
            $this->logger->log($priority, $message);
        }

        return $this;
    }
}
