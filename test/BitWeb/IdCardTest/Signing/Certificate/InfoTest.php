<?php

namespace BitWeb\IdCardTest\Signing\Certificate;

use BitWeb\IdCard\Signing\Certificate\Info;
use BitWeb\IdCard\Signing\Certificate\Policies;

class InfoTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(Info::class, new Info());
    }

    public function testGettersAndSetters()
    {
        $issuer = "C=EE/O=AS Sertifitseerimiskeskus/CN=TEST of EE Certification Centre Root CA/emailAddress=pki@sk.ee";
        $issuerSerial = "138983222239407220571566848351990841243";
        $subject = "C=EE/O=AS Sertifitseerimiskeskus/OU=OCSP/CN=TEST of SK OCSP RESPONDER 2011/emailAddress=pki@sk.ee";
        $validFrom = "2011-03-07T13:22:45Z";
        $validTo = "2024-09-07T12:22:45Z";
        $policies = new Policies();

        $info = new Info();
        $info->setIssuer($issuer);
        $info->setIssuerSerial($issuerSerial);
        $info->setSubject($subject);
        $info->setValidFrom($validFrom);
        $info->setValidTo($validTo);
        $info->setPolicies($policies);

        $this->assertEquals($issuer, $info->getIssuer());
        $this->assertEquals($issuerSerial, $info->getIssuerSerial());
        $this->assertEquals($subject, $info->getSubject());
        $this->assertEquals($validFrom, $info->getValidFrom());
        $this->assertEquals($validTo, $info->getValidTo());
        $this->assertInstanceOf(Policies::class, $info->getPolicies());
    }
} 