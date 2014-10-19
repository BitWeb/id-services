<?php

namespace BitWeb\IdServicesTest\Signing\IdCard;

use BitWeb\IdServices\Signing\IdCard\DataFileInfo;
use BitWeb\IdServices\Signing\IdCard\SignedDocInfo;

class SignedDocInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(SignedDocInfo::class, new SignedDocInfo());
    }

    public function testGettersAndSetters()
    {
        $format = 'DIGIDOC-XML';
        $version = '1.3';
        $dataFileInfo = new DataFileInfo();

        $signedDocInfo = new SignedDocInfo();
        $signedDocInfo->setFormat($format);
        $signedDocInfo->setVersion($version);
        $signedDocInfo->setDataFileInfo($dataFileInfo);

        $this->assertEquals($format, $signedDocInfo->getFormat());
        $this->assertEquals($version, $signedDocInfo->getVersion());
        $this->assertInstanceOf(DataFileInfo::class, $signedDocInfo->getDataFileInfo());
    }
}
