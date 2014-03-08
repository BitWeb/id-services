<?php

namespace BitWeb\IdCard;

class IdCardAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    protected function setSuccess()
    {
        $_SERVER[IdCardAuthentication::SSL_CLIENT_VERIFY] = IdCardAuthentication::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }

    protected function setUserAuthInfo()
    {
        $_SERVER['SSL_CLIENT_S_DN'] = 'GN=Mari-Liis/SN=Männik/serialNumber=47101010033/C=EST';
    }

    public function testIsSuccessfulReturnsFalse()
    {
        $this->assertFalse((new IdCardAuthentication())->isSuccessful());
    }

    public function testIsSuccessfulReturnsTrue()
    {
        $this->setSuccess();

        $this->assertTrue((new IdCardAuthentication())->isSuccessful());
    }

    /**
     * @expectedException \BitWeb\IdCard\AuthenticationException
     */
    public function testGetUserFailsWhenAuthNotSuccessful()
    {
        (new IdCardAuthentication())->getUser();
    }

    public function testGetUserReturnsIdCardUser()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();

        $user = (new IdCardAuthentication())->getUser();

        $this->assertInstanceOf(IdCardUser::class, $user);
        $this->assertEquals('Mari-Liis', $user->getFirstName());
        $this->assertEquals('Männik', $user->getLastName());
        $this->assertEquals('47101010033', $user->getSocialSecurityNumber());
        $this->assertEquals('EST', $user->getCountry());
    }
}