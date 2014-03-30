<?php

namespace BitWeb\IdCard\Signing\Certificate;

class Policies
{
    /**
     * @var string
     */
    protected $OID;

    /**
     * @var string
     */
    protected $URL;

    /**
     * @var string
     */
    protected $description;

    /**
     * @param string $OID
     */
    public function setOID($OID)
    {
        $this->OID = $OID;
    }

    /**
     * @return string
     */
    public function getOID()
    {
        return $this->OID;
    }

    /**
     * @param string $URL
     */
    public function setURL($URL)
    {
        $this->URL = $URL;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
} 