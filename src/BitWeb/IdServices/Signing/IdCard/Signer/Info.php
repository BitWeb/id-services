<?php

namespace BitWeb\IdServices\Signing\IdCard\Signer;

use BitWeb\IdServices\Signing\IdCard\Certificate\Info as CertificateInfo;

class Info
{
    /**
     * @var string
     */
    protected $CommonName;

    /**
     * @var string
     */
    protected $IDCode;

    /**
     * @var CertificateInfo
     */
    protected $Certificate;

    /**
     * @param CertificateInfo $Certificate
     */
    public function setCertificate(CertificateInfo $Certificate)
    {
        $this->Certificate = $Certificate;
    }

    /**
     * @return CertificateInfo
     */
    public function getCertificate()
    {
        return $this->Certificate;
    }

    /**
     * @param string $CommonName
     */
    public function setCommonName($CommonName)
    {
        $this->CommonName = $CommonName;
    }

    /**
     * @return string
     */
    public function getCommonName()
    {
        return $this->CommonName;
    }

    /**
     * @param string $IDCode
     */
    public function setIDCode($IDCode)
    {
        $this->IDCode = $IDCode;
    }

    /**
     * @return string
     */
    public function getIDCode()
    {
        return $this->IDCode;
    }
}
