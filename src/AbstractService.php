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

    /**
     * @param  string $bindTo IP address where outgoing requests are bound. Required for zone.ee servers as multiple
     *                        virtual servers share the same outgoing IP address. Format: 12.34.56.78:0
     *                        Please note the :0 at the end!
     * @return $this
     * @throws ServiceException
     */
    public function initSoap($bindTo = null)
    {
        if (null === $this->wsdl) {
            throw new ServiceException('No WSDL URL provided.');
        }

        $streamContextOptions = [];
        $options = [
            'soapVersion' => SOAP_1_1,
            'classMap' => $this->classMap
        ];

        if ($bindTo) {
            $streamContextOptions['socket'] = [
                'bindto' => $bindTo
            ];

            $this->log(Logger::INFO, 'Outgoing IP set to: ' . $bindTo);
        }

        // workaround for PHP5.6, needed for Travis tests to pass.
        if (version_compare(PHP_VERSION, '5.6.0') !== -1) {
            $streamContextOptions['ssl'] = [
                'verify_peer'       => false,
                'verify_peer_name'  => false
            ];
        }

        if (count($streamContextOptions) > 0) {
            $options['stream_context'] = stream_context_create($streamContextOptions);
        }

        $this->soap = new Client($this->wsdl, $options);
        $this->log(Logger::INFO, 'WSDL Client created. URL: ' . $this->getWsdl());

        return $this;
    }

    protected function throwIfSoapNotInitialized()
    {
        if (!$this->soap) {
            throw ServiceException::clientNotInitialized();
        }
    }

    /**
     * @param \SoapFault $e
     * @return ServiceException
     */
    protected function soapError(\SoapFault $e)
    {
        $this->log(Logger::ERR, 'SoapFault: ' . $e->getMessage());

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
