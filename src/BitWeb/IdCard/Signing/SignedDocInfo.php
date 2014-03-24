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
     * @var DataFile
     */
    protected $DataFileInfo;

    /**
     * @param \BitWeb\IdCard\Signing\DataFile $DataFileInfo
     */
    public function setDataFileInfo(DataFile $DataFileInfo)
    {
        $this->DataFileInfo = $DataFileInfo;
    }

    /**
     * @return \BitWeb\IdCard\Signing\DataFile
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