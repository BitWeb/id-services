<?php

namespace BitWeb\IdCard\Signing\Signer;

use BitWeb\IdCard\Signing\Certificate\Info as CertificateInfo;

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
     * @param \BitWeb\IdCard\Signing\Certificate\Info $Certificate
     */
    public function setCertificate(CertificateInfo $Certificate)
    {
        $this->Certificate = $Certificate;
    }

    /**
     * @return \BitWeb\IdCard\Signing\Certificate\Info
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