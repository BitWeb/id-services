<?php

namespace BitWeb\IdCard;

class IdCardUserTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateIdCardUser()
    {
        $firstName = 'John';
        $lastName = 'Doe';
        $personalCode = '38601012796';
        $country = 'EST';

        $user = new IdCardUser($firstName, $lastName, $personalCode, $country);

        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($personalCode, $user->getSocialSecurityNumber());
        $this->assertEquals($country, $user->getCountry());
    }
}
