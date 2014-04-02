<?php

namespace BitWeb\IdCard\Signing;

use BitWeb\IdCard\Authentication\IdCardAuthentication;
use BitWeb\IdCard\Signing\Exception\ServiceException;
use BitWeb\IdCard\Signing\Exception\SigningException;
use Zend\Soap\Client;

class SignatureService
{
    const DDOC_DOWNLOAD_ERROR = 'Error when downloading DDOC file.';

    protected $wsdl;

    /**
     * Error codes translated according to http://www.sk.ee/upload/files/DigiDocService_spec_est.pdf version 2.127
     *
     * @var array
     */
    protected $errorCodeMap = [
        '100' => ServiceException::ERROR_CODE_100,
        '101' => ServiceException::ERROR_CODE_101,
        '102' => ServiceException::ERROR_CODE_102,
        '103' => ServiceException::ERROR_CODE_103,
        '200' => ServiceException::ERROR_CODE_200,
        '201' => ServiceException::ERROR_CODE_201,
        '202' => ServiceException::ERROR_CODE_202,
        '203' => ServiceException::ERROR_CODE_203,
        '300' => ServiceException::ERROR_CODE_300,
        '301' => ServiceException::ERROR_CODE_301,
        '302' => ServiceException::ERROR_CODE_302,
        '303' => ServiceException::ERROR_CODE_303,
        '304' => ServiceException::ERROR_CODE_304,
        '305' => ServiceException::ERROR_CODE_305,
        '413' => ServiceException::ERROR_CODE_413,
        '503' => ServiceException::ERROR_CODE_503
    ];

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

        return $this;
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

        return $this;
    }

    public function startSession($fileName)
    {
        if (!IdCardAuthentication::isUserLoggedIn()) {
            IdCardAuthentication::login();
        }

        $dataFile = new DataFileInfo();
        $dataFile->fillData($fileName);

        try {
            return $this->soap->startSession("", "", true, $dataFile->toArray())['Sesscode'];
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function prepareSignature($sessionCode, $certificateId, $certificateHex)
    {
        try {
            return $this->soap->prepareSignature($sessionCode, $certificateHex, $certificateId);
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function finalizeSignature($sessionCode, $signatureId, $signatureHex)
    {
        try {
            return $this->soap->finalizeSignature($sessionCode, $signatureId, $signatureHex);
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function getSignedDoc($sessionCode)
    {
        try {
            $result = $this->soap->getSignedDoc($sessionCode);
            if ($result['Status'] === 'OK') {
                return html_entity_decode($result['SignedDocData']);
            } else {
                throw new SigningException(self::DDOC_DOWNLOAD_ERROR);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function getSignedDocInfo($sessionCode)
    {
        try {
            return $this->soap->getSignedDocInfo($sessionCode);
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    protected function catchSoapError(\SoapFault $e)
    {
        $code = $e->getMessage();
        throw new ServiceException($this->errorCodeMap[$code], $code);
    }
}