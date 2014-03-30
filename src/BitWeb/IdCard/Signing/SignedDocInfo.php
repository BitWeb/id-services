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