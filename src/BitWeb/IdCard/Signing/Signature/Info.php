<?php

namespace BitWeb\IdCard\Signing\Signature;

use BitWeb\IdCard\Signing\ConfirmationInfo;
use BitWeb\IdCard\Signing\Error;
use BitWeb\IdCard\Signing\Signer;
use BitWeb\IdCard\Signing;

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
     * @param \BitWeb\IdCard\Signing\ConfirmationInfo $Confirmation
     */
    public function setConfirmation(ConfirmationInfo $Confirmation)
    {
        $this->Confirmation = $Confirmation;
    }

    /**
     * @return \BitWeb\IdCard\Signing\ConfirmationInfo
     */
    public function getConfirmation()
    {
        return $this->Confirmation;
    }

    /**
     * @param \BitWeb\IdCard\Signing\Error $Error
     */
    public function setError(Error $Error)
    {
        $this->Error = $Error;
    }

    /**
     * @return \BitWeb\IdCard\Signing\Error
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
     * @param \BitWeb\IdCard\Signing\Signer\Role $SignerRole
     */
    public function setSignerRole(Signer\Role $SignerRole)
    {
        $this->SignerRole = $SignerRole;
    }

    /**
     * @return \BitWeb\IdCard\Signing\Signer\Role
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