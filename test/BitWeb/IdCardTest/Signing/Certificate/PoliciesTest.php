<?php

namespace BitWeb\IdCardTest\Signing\Certificate;

use BitWeb\IdCard\Signing\Certificate\Policies;

class PoliciesTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(Policies::class, new Policies());
    }

    public function testGettersAndSetters()
    {
        $OID = "";
        $URL = "";
        $description = "test";

        $policies = new Policies();
        $policies->setOID($OID);
        $policies->setURL($URL);
        $policies->setDescription($description);

        $this->assertEquals($OID, $policies->getOID());
        $this->assertEquals($URL, $policies->getURL());
        $this->assertEquals($description, $policies->getDescription());
    }
} 