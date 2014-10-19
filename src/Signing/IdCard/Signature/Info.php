<?php

namespace BitWeb\IdServices\Signing\IdCard\Signature;

use BitWeb\IdServices\Signing\IdCard\ConfirmationInfo;
use BitWeb\IdServices\Signing\IdCard\Error;
use BitWeb\IdServices\Signing\IdCard\Signer;

class Info
{
    /**
     * @var string
     */
    protected $Id;

    /**
     * @var string
     */
    protected $Status;

    /**
     * @var Error
     */
    protected $Error;

    /**
     * @var string
     */
    protected $SigningTime;

    /**
     * @var Signer\Role
     */
    protected $SignerRole;

    /**
     * @var ProductionPlace
     */
    protected $SignatureProductionPlace;

    /**
     * @var Signer\Info
     */
    protected $Signer;

    /**
     * @var ConfirmationInfo
     */
    protected $Confirmation;

    /**
     * @var string
     */
    protected $Timestamps;

    /**
     * @var string
     */
    protected $CRLInfo;

    /**
     * @param string $CRLInfo
     */
    public function setCRLInfo($CRLInfo)
    {
        $this->CRLInfo = $CRLInfo;
    }

    /**
     * @return string
     */
    public function getCRLInfo()
    {
        return $this->CRLInfo;
    }

    /**
     * @param ConfirmationInfo $Confirmation
     */
    public function setConfirmation(ConfirmationInfo $Confirmation)
    {
        $this->Confirmation = $Confirmation;
    }

    /**
     * @return ConfirmationInfo
     */
    public function getConfirmation()
    {
        return $this->Confirmation;
    }

    /**
     * @param Error $Error
     */
    public function setError(Error $Error)
    {
        $this->Error = $Error;
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->Error;
    }

    /**
     * @param string $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param ProductionPlace $SignatureProductionPlace
     */
    public function setSignatureProductionPlace(ProductionPlace $SignatureProductionPlace)
    {
        $this->SignatureProductionPlace = $SignatureProductionPlace;
    }

    /**
     * @return ProductionPlace
     */
    public function getSignatureProductionPlace()
    {
        return $this->SignatureProductionPlace;
    }

    /**
     * @param Signer\Info $Signer
     */
    public function setSigner(Signer\Info $Signer)
    {
        $this->Signer = $Signer;
    }

    /**
     * @return Signer\Info
     */
    public function getSigner()
    {
        return $this->Signer;
    }

    /**
     * @param Signer\Role $SignerRole
     */
    public function setSignerRole(Signer\Role $SignerRole)
    {
        $this->SignerRole = $SignerRole;
    }

    /**
     * @return Signer\Role
     */
    public function getSignerRole()
    {
        return $this->SignerRole;
    }

    /**
     * @param string $SigningTime
     */
    public function setSigningTime($SigningTime)
    {
        $this->SigningTime = $SigningTime;
    }

    /**
     * @return string
     */
    public function getSigningTime()
    {
        return $this->SigningTime;
    }

    /**
     * @param string $Status
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param string $Timestamps
     */
    public function setTimestamps($Timestamps)
    {
        $this->Timestamps = $Timestamps;
    }

    /**
     * @return string
     */
    public function getTimestamps()
    {
        return $this->Timestamps;
    }
}
