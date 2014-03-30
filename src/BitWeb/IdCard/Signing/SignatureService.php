<?php

namespace BitWeb\IdCard\Signing;

use BitWeb\IdCard\Authentication\IdCardAuthentication;
use Zend\Soap\Client;

class SignatureService
{
    protected $wsdl;

    protected $classMap = [
        'CertificateInfo'           => Certificate\Info::class,
        'CertificatePolicy'         => Certificate\Policies::class,
        'ConfirmationInfo'          => ConfirmationInfo::class,
        'DataFileInfo'              => DataFileInfo::class,
        'DateTime'                  => \DateTime::class,
        'Error'                     => Error::class,
        'ResponderCertificate'      => Certificate\Info::class,
        'SignedDocInfo'             => SignedDocInfo::class,
        'SignatureInfo'             => Signature\Info::class,
        'SignatureProductionPlace'  => Signature\ProductionPlace::class,
        'SignerInfo'                => Signer\Info::class,
        'SignerRole'                => Signer\Role::class,
    ];

    /**
     * @var Client
     */
    protected $soap;

    public function setWsdl($wsdl = 'https://www.openxades.org:9443/?wsdl')
    {
        $this->wsdl = $wsdl;
    }

    public function getWsdl()
    {
        return $this->wsdl;
    }

    public function initSoap()
    {
        $this->soap = new Client($this->wsdl, array(
            'soapVersion' => SOAP_1_1,
            'classMap' => $this->classMap
        ));
    }

    public function startSession($fileName)
    {
        if (!IdCardAuthentication::isUserLoggedIn()) {
            IdCardAuthentication::login();
        }

        $dataFile = new DataFileInfo();
        $dataFile->fillData($fileName);

        $result = $this->soap->startSession("", "", true, $dataFile->toArray());

        return $result['Sesscode'];
    }

    public function prepareSignature($sessionCode, $certificateId, $certificateHex)
    {
        return $this->soap->prepareSignature($sessionCode, $certificateHex, $certificateId);
    }

    public function finalizeSignature($sessionCode, $signatureId, $signatureHex)
    {
        return $this->soap->finalizeSignature($sessionCode, $signatureId, $signatureHex);
    }
}