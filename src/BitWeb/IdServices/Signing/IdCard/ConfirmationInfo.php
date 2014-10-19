<?php

namespace BitWeb\IdServices\Signing\IdCard;

class ConfirmationInfo
{
    /**
     * @var string
     */
    protected $ResponderID;

    /**
     * @var string
     */
    protected $ProducedAt;

    /**
     * @var Certificate\Info
     */
    protected $ResponderCertificate;

    /**
     * @param string $ProducedAt
     */
    public function setProducedAt($ProducedAt)
    {
        $this->ProducedAt = $ProducedAt;
    }

    /**
     * @return string
     */
    public function getProducedAt()
    {
        return $this->ProducedAt;
    }

    /**
     * @param \BitWeb\IdCard\Signing\Certificate\Info $ResponderCertificate
     */
    public function setResponderCertificate(Certificate\Info $ResponderCertificate)
    {
        $this->ResponderCertificate = $ResponderCertificate;
    }

    /**
     * @return \BitWeb\IdCard\Signing\Certificate\Info
     */
    public function getResponderCertificate()
    {
        return $this->ResponderCertificate;
    }

    /**
     * @param string $ResponderID
     */
    public function setResponderID($ResponderID)
    {
        $this->ResponderID = $ResponderID;
    }

    /**
     * @return string
     */
    public function getResponderID()
    {
        return $this->ResponderID;
    }
}
