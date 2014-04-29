<?php

namespace BitWeb\IdCard\Signing\Signature;

class ProductionPlace
{
    /**
     * @var string
     */
    protected $City;

    /**
     * @var string
     */
    protected $StateOrProvince;

    /**
     * @var string
     */
    protected $PostalCode;

    /**
     * @var string
     */
    protected $CountryName;

    /**
     * @param string $City
     */
    public function setCity($City)
    {
        $this->City = $City;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param string $CountryName
     */
    public function setCountryName($CountryName)
    {
        $this->CountryName = $CountryName;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->CountryName;
    }

    /**
     * @param string $PostalCode
     */
    public function setPostalCode($PostalCode)
    {
        $this->PostalCode = $PostalCode;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     * @param string $StateOrProvince
     */
    public function setStateOrProvince($StateOrProvince)
    {
        $this->StateOrProvince = $StateOrProvince;
    }

    /**
     * @return string
     */
    public function getStateOrProvince()
    {
        return $this->StateOrProvince;
    }
} 