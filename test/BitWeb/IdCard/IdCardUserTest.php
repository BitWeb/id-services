<?php

namespace BitWeb\IdCard;

class IdCardUserTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateIdCardUser()
    {
        new IdCardUser('John', 'Doe', '38601012796', 'EST');
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
