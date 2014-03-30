<?php

namespace BitWeb\IdCardTest\Signing;

use BitWeb\IdCard\Signing\DataFileInfo;
use BitWeb\IdCard\Signing\SignedDocInfo;

class SignedDocInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        new SignedDocInfo();
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