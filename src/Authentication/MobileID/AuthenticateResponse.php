<?php

namespace BitWeb\IdServices\Authentication\MobileID;

class AuthenticateResponse
{
    /**
     * @var int
     */
    protected $SessCode;

    /**
     * @var string
     */
    protected $Status;

    /**
     * @var string
     */
    protected $UserIdCode;

    /**
     * @var string
     */
    protected $UserGivenname;

    /**
     * @var string
     */
    protected $UserSurname;

    /**
     * @var string
     */
    protected $UserCountry;

    /**
     * @var string
     */
    protected $UserCN;

    /**
     * @var string
     */
    protected $CertificateData;

    /**
     * @var string
     */
    protected $ChallengeID;

    /**
     * @var string
     */
    protected $Challenge;

    /**
     * @var string
     */
    protected $RevocationData;

    /**
     * @return int
     */
    public function getSessCode()
    {
        return $this->SessCode;
    }

    /**
     * @param int $SessCode
     * @return self
     */
    public function setSessCode($SessCode)
    {
        $this->SessCode = (int)$SessCode;
        return $this;
    }

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
    public function getUserIdCode()
    {
        return $this->UserIdCode;
    }

    /**
     * @param string $UserIdCode
     * @return self
     */
    public function setUserIdCode($UserIdCode)
    {
        $this->UserIdCode = $UserIdCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserGivenname()
    {
        return $this->UserGivenname;
    }

    /**
     * @param string $UserGivenname
     * @return self
     */
    public function setUserGivenname($UserGivenname)
    {
        $this->UserGivenname = $UserGivenname;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserSurname()
    {
        return $this->UserSurname;
    }

    /**
     * @param string $UserSurname
     * @return self
     */
    public function setUserSurname($UserSurname)
    {
        $this->UserSurname = $UserSurname;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserCountry()
    {
        return $this->UserCountry;
    }

    /**
     * @param string $UserCountry
     * @return self
     */
    public function setUserCountry($UserCountry)
    {
        $this->UserCountry = $UserCountry;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserCN()
    {
        return $this->UserCN;
    }

    /**
     * @param string $UserCN
     * @return self
     */
    public function setUserCN($UserCN)
    {
        $this->UserCN = $UserCN;
        return $this;
    }

    /**
     * @return string
     */
    public function getCertificateData()
    {
        return $this->CertificateData;
    }

    /**
     * @param string $CertificateData
     * @return self
     */
    public function setCertificateData($CertificateData)
    {
        $this->CertificateData = $CertificateData;
        return $this;
    }

    /**
     * @return string
     */
    public function getChallengeID()
    {
        return $this->ChallengeID;
    }

    /**
     * @param string $ChallengeID
     * @return self
     */
    public function setChallengeID($ChallengeID)
    {
        $this->ChallengeID = $ChallengeID;
        return $this;
    }

    /**
     * @return string
     */
    public function getChallenge()
    {
        return $this->Challenge;
    }

    /**
     * @param string $Challenge
     * @return self
     */
    public function setChallenge($Challenge)
    {
        $this->Challenge = $Challenge;
        return $this;
    }

    /**
     * @return string
     */
    public function getRevocationData()
    {
        return $this->RevocationData;
    }

    /**
     * @param string $RevocationData
     * @return self
     */
    public function setRevocationData($RevocationData)
    {
        $this->RevocationData = $RevocationData;
        return $this;
    }
}
