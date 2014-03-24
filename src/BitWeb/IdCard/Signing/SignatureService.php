<?php

namespace BitWeb\IdCard\Signing;

use BitWeb\IdCard\Authentication\IdCardAuthentication;
use Zend\Soap\Client;

class SignatureService
{
    protected $testWsdl = 'https://www.openxades.org:9443/?wsdl';

    protected $classMap = [
        'DataFileInfo' => 'BitWeb\IdCard\Signing\DataFile',
        'SignedDocInfo' => 'BitWeb\IdCard\Signing\SignedDocInfo'
    ];

    /**
     * @var Client
     */
    protected $soap;

    public function initSoap()
    {
        $this->soap = new Client($this->testWsdl, array(
            'soap_version' => SOAP_1_1,
            'classMap' => $this->classMap
        ));
    }

    public function startSession($fileName)
    {
        if (!IdCardAuthentication::isUserLoggedIn()) {
            IdCardAuthentication::login();
        }

        $dataFile = new DataFile();
        $dataFile->fillData($fileName);

        $result = $this->soap->startSession("", "", true, $dataFile->toArray());

        return $result['Sesscode'];
    }
}