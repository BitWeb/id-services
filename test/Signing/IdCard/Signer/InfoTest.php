<?php

namespace BitWeb\IdServicesTest\Signing\IdCard\Signer;

use BitWeb\IdServices\Signing\IdCard\Certificate\Info as CertificateInfo;
use BitWeb\IdServices\Signing\IdCard\Signer\Info;

class InfoTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(Info::class, new Info());
    }

    public function testSettersAndGetters()
    {
        $commonName = "MÄNNIK,MARI-LIIS,47101010033";
        $IDCode = "47101010033";
        $certificate = new CertificateInfo();

        $info = new Info();
        $info->setCommonName($commonName);
        $info->setIDCode($IDCode);
        $info->setCertificate($certificate);

        $this->assertEquals($commonName, $info->getCommonName());
        $this->assertEquals($IDCode, $info->getIDCode());
        $this->assertEquals($certificate, $info->getCertificate());
    }
}
