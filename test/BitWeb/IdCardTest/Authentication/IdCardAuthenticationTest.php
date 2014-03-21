<?php

namespace BitWeb\IdCardTest\Authentication;

use BitWeb\IdCard\Authentication\IdCardAuthentication;
use BitWeb\IdCard\Authentication\IdCardUser;

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
        $this->assertFalse(IdCardAuthentication::isSuccessful());
    }

    public function testIsSuccessfulReturnsTrue()
    {
        $this->setSuccess();

        $this->assertTrue(IdCardAuthentication::isSuccessful());
    }

    /**
     * @expectedException \BitWeb\IdCard\Authentication\AuthenticationException
     */
    public function testLoginThrowsWhenAuthNotSuccessful()
    {
        IdCardAuthentication::login();
    }

    /**
     * @expectedException \BitWeb\IdCard\Authentication\AuthenticationException
     */
    public function testGetLoggedInUserFailsWhenAuthNotSuccessful()
    {
        IdCardAuthentication::getLoggedInUser();
    }

    public function testGetLoggedInUserReturnsIdCardUser()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();

        IdCardAuthentication::login();

        $user = IdCardAuthentication::getLoggedInUser();

        $this->assertInstanceOf(IdCardUser::class, $user);
        $this->assertEquals('Mari-Liis', $user->getFirstName());
        $this->assertEquals('Männik', $user->getLastName());
        $this->assertEquals('47101010033', $user->getSocialSecurityNumber());
        $this->assertEquals('EST', $user->getCountry());

        $this->assertInstanceOf(IdCardUser::class, unserialize($_SESSION[IdCardAuthentication::ID_CARD_USER_AUTH_SESSION_KEY]));
    }

    public function testIsUserLoggedIn()
    {
        $this->assertFalse(IdCardAuthentication::isUserLoggedIn());

        $this->setSuccess();
        $this->setUserAuthInfo();

        IdCardAuthentication::login();

        $this->assertTrue(IdCardAuthentication::isUserLoggedIn());
    }

    /**
     * @expectedException \BitWeb\IdCard\Authentication\AuthenticationException
     */
    public function testLogoutThrowsWhenUserNotLoggedIn()
    {
        IdCardAuthentication::logout();
    }

    public function testLogout()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();

        IdCardAuthentication::login();
        IdCardAuthentication::logout();

        $this->assertFalse(isset($_SESSION[IdCardAuthentication::ID_CARD_USER_AUTH_SESSION_KEY]));
    }
}