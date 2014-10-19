<?php

namespace BitWeb\IdServicesTest\Signing\IdCard;

use BitWeb\IdServices\Signing\IdCard\Error;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(Error::class, new Error());
    }

    public function testSettersAndGetters()
    {
        $code = "";
        $category = "";
        $description = "";

        $error = new Error();
        $error->setCode($code);
        $error->setCategory($category);
        $error->setDescription($description);

        $this->assertEquals($code, $error->getCode());
        $this->assertEquals($category, $error->getCategory());
        $this->assertEquals($description, $error->getDescription());
    }
}
