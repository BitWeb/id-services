<?php

namespace BitWeb\IdServices\Signing\IdCard\Signer;

class Role
{
    /**
     * @var string
     */
    protected $Certified;

    /**
     * @var string
     */
    protected $Role;

    /**
     * @param string $Certified
     */
    public function setCertified($Certified)
    {
        $this->Certified = $Certified;
    }

    /**
     * @return string
     */
    public function getCertified()
    {
        return $this->Certified;
    }

    /**
     * @param string $Role
     */
    public function setRole($Role)
    {
        $this->Role = $Role;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->Role;
    }
}
