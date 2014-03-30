<?php

namespace BitWeb\IdCard\Signing\Certificate;

class Info
{
    /**
     * @var string
     */
    protected $Issuer;

    /**
     * @var string
     */
    protected $IssuerSerial;

    /**
     * @var string
     */
    protected $Subject;

    /**
     * @var string
     */
    protected $ValidFrom;

    /**
     * @var string
     */
    protected $ValidTo;

    /**
     * @var Policies
     */
    protected $Policies;

    /**
     * @param string $Issuer
     */
    public function setIssuer($Issuer)
    {
        $this->Issuer = $Issuer;
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->Issuer;
    }

    /**
     * @param string $IssuerSerial
     */
    public function setIssuerSerial($IssuerSerial)
    {
        $this->IssuerSerial = $IssuerSerial;
    }

    /**
     * @return string
     */
    public function getIssuerSerial()
    {
        return $this->IssuerSerial;
    }

    /**
     * @param Policies $Policies
     */
    public function setPolicies(Policies $Policies)
    {
        $this->Policies = $Policies;
    }

    /**
     * @return Policies
     */
    public function getPolicies()
    {
        return $this->Policies;
    }

    /**
     * @param string $Subject
     */
    public function setSubject($Subject)
    {
        $this->Subject = $Subject;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->Subject;
    }

    /**
     * @param string $ValidFrom
     */
    public function setValidFrom($ValidFrom)
    {
        $this->ValidFrom = $ValidFrom;
    }

    /**
     * @return string
     */
    public function getValidFrom()
    {
        return $this->ValidFrom;
    }

    /**
     * @param string $ValidTo
     */
    public function setValidTo($ValidTo)
    {
        $this->ValidTo = $ValidTo;
    }

    /**
     * @return string
     */
    public function getValidTo()
    {
        return $this->ValidTo;
    }
} 