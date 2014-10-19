<?php

namespace BitWeb\IdCard;

use BitWeb\IdCard\Exception\ServiceException;
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

    public function setWsdl($wsdl = 'https://www.openxades.org:9443/?wsdl')
    {
        $this->wsdl = $wsdl;

        return $this;
    }

    public function getWsdl()
    {
        return $this->wsdl;
    }

    public function initSoap()
    {
        if ([] === $this->classMap) {
            throw new ServiceException('No class map provided.');
        }

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
}
