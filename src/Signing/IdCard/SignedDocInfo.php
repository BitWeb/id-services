<?php

namespace BitWeb\IdServices\Signing\IdCard;

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
     * @param DataFileInfo $DataFileInfo
     */
    public function setDataFileInfo(DataFileInfo $DataFileInfo)
    {
        $this->DataFileInfo = $DataFileInfo;
    }

    /**
     * @return DataFileInfo
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
     * @param Signature\Info $SignatureInfo
     */
    public function setSignatureInfo(Signature\Info $SignatureInfo)
    {
        $this->SignatureInfo = $SignatureInfo;
    }

    /**
     * @return Signature\Info
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
