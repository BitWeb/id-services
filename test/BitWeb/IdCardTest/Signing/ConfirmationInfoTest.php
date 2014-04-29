<?php

namespace BitWeb\IdCardTest\Signing;

use BitWeb\IdCard\Signing\Certificate\Info as CertificateInfo;
use BitWeb\IdCard\Signing\ConfirmationInfo;

class ConfirmationInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(ConfirmationInfo::class, new ConfirmationInfo());
    }

    public function testSettersAndGetters()
    {
        $responderID = "C=EE/O=AS Sertifitseerimiskeskus/OU=OCSP/CN=TEST of SK OCSP RESPONDER 2011/emailAddress=pki@sk.ee";
        $producedAt = "2014-03-27T13:56:41Z";
        $responderCertificate = new CertificateInfo();

        $info = new ConfirmationInfo();
        $info->setResponderID($responderID);
        $info->setProducedAt($producedAt);
        $info->setResponderCertificate($responderCertificate);

        $this->assertEquals($responderID, $info->getResponderID());
        $this->assertEquals($producedAt, $info->getProducedAt());
        $this->assertInstanceOf(CertificateInfo::class, $info->getResponderCertificate());
    }
} 