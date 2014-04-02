<?php

namespace BitWeb\IdCard\Signing;

class SignedDocInfo
{
    /**
     * @var string
     */
    protected $Format;

    /**
     * @var string
     */
    protected $Version;

    /**
     * @var DataFileInfo
     */
    protected $DataFileInfo;

    /**
     * @var Signature\Info
     */
    protected $SignatureInfo;

    /**
     * @param \BitWeb\IdCard\Signing\DataFileInfo $DataFileInfo
     */
    public function setDataFileInfo(DataFileInfo $DataFileInfo)
    {
        $this->DataFileInfo = $DataFileInfo;
    }

    /**
     * @return \BitWeb\IdCard\Signing\DataFileInfo
     */
    public function getDataFileInfo()
    {
        return $this->DataFileInfo;
    }

    /**
     * @param string $Format
     */
    public function setFormat($Format)
    {
        $this->Format = $Format;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->Format;
    }

    /**
     * @param \BitWeb\IdCard\Signing\Signature\Info $SignatureInfo
     */
    public function setSignatureInfo(Signature\Info $SignatureInfo)
    {
        $this->SignatureInfo = $SignatureInfo;
    }

    /**
     * @return \BitWeb\IdCard\Signing\Signature\Info
     */
    public function getSignatureInfo()
    {
        return $this->SignatureInfo;
    }

    /**
     * @param string $Version
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->Version;
    }
} 