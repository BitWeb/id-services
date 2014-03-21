<?php

namespace BitWeb\IdCardTest\Authentication;

use BitWeb\IdCard\Authentication\IdCardUser;

class IdCardUserTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateIdCardUser()
    {
        $firstName = 'John';
        $lastName = 'Doe';
        $socialSecurityNumber = '38601012796';
        $country = 'EST';

        $user = new IdCardUser($firstName, $lastName, $socialSecurityNumber, $country);

        $this->assertInstanceOf(IdCardUser::class, $user);
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($socialSecurityNumber, $user->getSocialSecurityNumber());
        $this->assertEquals($country, $user->getCountry());
    }

    public function testSettersAndGetters()
    {
        $firstName = 'John';
        $lastName = 'Doe';
        $socialSecurityNumber = '38601012796';
        $country = 'EST';

        $user = new IdCardUser();
        $user->setCountry($country);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setSocialSecurityNumber($socialSecurityNumber);

        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($socialSecurityNumber, $user->getSocialSecurityNumber());
        $this->assertEquals($country, $user->getCountry());
    }
}
