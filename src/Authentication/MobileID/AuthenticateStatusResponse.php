<?php

namespace BitWeb\IdServices\Authentication\MobileID;

class AuthenticateStatusResponse
{
    /**
     * @var string
     */
    protected $Status;

    /**
     * @var string
     */
    protected $Signature;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     * @return self
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->Signature;
    }

    /**
     * @param string $Signature
     * @return self
     */
    public function setSignature($Signature)
    {
        $this->Signature = $Signature;
        return $this;
    }
}
