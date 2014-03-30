<?php

namespace BitWeb\IdCardTest\Signing\Signer;

use BitWeb\IdCard\Signing\Signer\Role;

class RoleTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(Role::class, new Role());
    }

    public function testSettersAndGetters()
    {
        $certified = "";
        $roleString = "CEO";

        $role = new Role();
        $role->setCertified($certified);
        $role->setRole($roleString);

        $this->assertEquals($certified, $role->getCertified());
        $this->assertEquals($roleString, $role->getRole());
    }
} 