<?php

namespace BitWeb\IdCardTest\Signing;

use BitWeb\IdCard\Signing\DataFileInfo;

class DataFileTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(DataFileInfo::class, new DataFileInfo());
    }

    public function testSettersAndGetters()
    {
        $id = "D0";
        $fileName = 'test.txt';
        $contentType = DataFileInfo::CONTENT_TYPE_EMBEDDED_BASE64;
        $mimeType = 'text/plain';
        $size = 42;
        $digestType = DataFileInfo::DIGEST_TYPE_SHA1;
        $digestValue = 'QeFwxdWPddDTA2ozRcdhR/WEf/I=';
        $dfData = 'dfData';

        $dataFile = new DataFileInfo();
        $dataFile->setId($id);
        $dataFile->setFilename($fileName);
        $dataFile->setContentType($contentType);
        $dataFile->setMimeType($mimeType);
        $dataFile->setSize($size);
        $dataFile->setDigestType($digestType);
        $dataFile->setDigestValue($digestValue);
        $dataFile->setDfData($dfData);

        $this->assertEquals($id, $dataFile->getId());
        $this->assertEquals($fileName, $dataFile->getFilename());
        $this->assertEquals($contentType, $dataFile->getContentType());
        $this->assertEquals($mimeType, $dataFile->getMimeType());
        $this->assertEquals($size, $dataFile->getSize());
        $this->assertEquals($digestType, $dataFile->getDigestType());
        $this->assertEquals($digestValue, $dataFile->getDigestValue());
        $this->assertEquals($dfData, $dataFile->getDfData());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetContentTypeThrowsOnInvalidValue()
    {
        $dataFile = new DataFileInfo();

        $dataFile->setContentType('wrong type');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetDigestTypeThrowsOnInvalidValue()
    {
        $dataFile = new DataFileInfo();

        $dataFile->setDigestType('wrong type');
    }
} 