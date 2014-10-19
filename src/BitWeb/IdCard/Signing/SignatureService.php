<?php

namespace BitWeb\IdCard\Signing;

use BitWeb\IdCard\AbstractService;
use BitWeb\IdCard\Authentication\IdCardAuthentication;
use BitWeb\IdCard\Signing\Exception\ServiceException;
use BitWeb\IdCard\Signing\Exception\SigningException;
use Zend\Soap\Client;

class SignatureService extends AbstractService
{

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

    public function startSession($fileName, $fileOriginalName = null)
    {
        if (!IdCardAuthentication::isUserLoggedIn()) {
            IdCardAuthentication::login();
        }

        $dataFile = new DataFileInfo();
        $dataFile->fillData($fileName, $fileOriginalName);

        try {
            $result = $this->soap->startSession("", "", true, $dataFile->toArray())['Sesscode'];
            if (is_int($result)) {
                return $result;
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function prepareSignature($sessionCode, $certificateId, $certificateHex)
    {
        try {
            $result = $this->soap->prepareSignature($sessionCode, $certificateHex, $certificateId);
            if ($result['Status'] === 'OK') {
                return $result;
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function finalizeSignature($sessionCode, $signatureId, $signatureHex)
    {
        try {
            $result = $this->soap->finalizeSignature($sessionCode, $signatureId, $signatureHex);
            if ($result['Status'] === 'OK') {
                return $result;
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function getSignedDoc($sessionCode, $signedFile)
    {
        try {
            $result = $this->soap->getSignedDoc($sessionCode);
            if ($result['Status'] === 'OK') {
                return $this->replaceDataFile(html_entity_decode($result['SignedDocData']), $signedFile);
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function getSignedDocInfo($sessionCode)
    {
        try {
            $result = $this->soap->getSignedDocInfo($sessionCode);
            if ($result['Status'] === 'OK') {
                return $result;
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    protected function catchSoapError(\SoapFault $e)
    {
        $code = $e->getMessage();
        throw new ServiceException(ServiceException::$errorCodeMap[$code], $code);
    }

    protected function replaceDataFile($SignedDocData, $signedFile)
    {
        $data = simplexml_load_string($SignedDocData);

        // TODO check that the file is the same file

        $old = dom_import_simplexml($data->DataFile);
        $new = DataFileInfo::formXml($data->DataFile->asXml(), $signedFile)->getDomElement();
        $nodeImport = $old->ownerDocument->importNode($new, true);
        $old->parentNode->replaceChild($nodeImport, $old);

        return $data->asXML();
    }

    public function closeSession($sessionId)
    {
        try {
            $result = $this->soap->closeSession($sessionId);
            if ($result === 'OK') {
                return $result;
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }


    public function getSignedDocInfoByPath( $documentPath )
    {
        $contents = file_get_contents($documentPath);
        $contents = $this->prepareDdocDataFile($contents);

        try {
            $result = $this->soap->startSession("", $contents, true);
            if (is_int($result['Sesscode'])) {
                return $result['SignedDocInfo'];
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function startDdockSession($documentPath, $storePath)
    {
        if (!IdCardAuthentication::isUserLoggedIn()) {
            IdCardAuthentication::login();
        }

        try {

            $contents = file_get_contents($documentPath);
            $contents = $this->prepareDdocDataFile($contents, $storePath);

            $result = $this->soap->startSession("", $contents, true)['Sesscode'];
            if (is_int($result)) {
                return $result;
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    public function prepareDdocDataFile($documentContents, $storePath = NULL)
    {
        $data = simplexml_load_string($documentContents);

        if(!is_object($data->DataFile)){
            return NULL;
        }

        $xml = simplexml_load_string( $data->DataFile->asXml() );

        if($storePath){
            file_put_contents($storePath, base64_decode((string)$xml));
        }

        $dataArray = $xml->attributes();
        $doc = new \DOMDocument(null, 'UTF-8');
        $dom = new \DOMElement('DataFile', "" . "\n", DataFileInfo::$xmlNamespace);

        $doc->appendChild($dom);
        $dom->setAttribute('namespace', DataFileInfo::$xmlNamespace);
        $dom->setAttribute('ContentType', DataFileInfo::CONTENT_TYPE_HASH_CODE);
        $dom->setAttribute('Filename',$dataArray['Filename']->__toString());
        $dom->setAttribute('Id',$dataArray['Id']->__toString());
        $dom->setAttribute('MimeType',$dataArray['MimeType']->__toString());
        $dom->setAttribute('Size',$dataArray['Size']->__toString());
        $dom->setAttribute('DigestType', DataFileInfo::DIGEST_TYPE_SHA1);
        $dataFile = dom_import_simplexml($data->DataFile)->C14N(false, false);
        $encoded = hash(DataFileInfo::DIGEST_TYPE_SHA1, $dataFile);
        $digestValue = base64_encode(pack('H*', $encoded));
        $dom->setAttribute('DigestValue', $digestValue);
        $old = dom_import_simplexml($data->DataFile);
        $nodeImport = $old->ownerDocument->importNode($dom, true);
        $old->parentNode->replaceChild($nodeImport, $old);
        $dataString = $data->asXML();
        $dataString = str_replace('namespace','xmlns', $dataString);
        return $dataString;
    }

    public function removeSignature( $sessionId, $signatureId )
    {
        try {
            $result = $this->soap->removeSignature($sessionId, $signatureId);
            if ($result['Status'] === 'OK') {
                return $result['SignedDocInfo'];
            } else {
                throw new SigningException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }
}
