<?php

namespace BitWeb\IdServicesTest\Authentication\IdCard;

use BitWeb\IdServices\Authentication\IdCard\Authentication;
use BitWeb\IdServices\Authentication\IdCard\User;

class AuthenticationTest extends \PHPUnit_Framework_TestCase
{
    protected function setSuccess()
    {
        $_SERVER[Authentication::SSL_CLIENT_VERIFY] = Authentication::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }

    protected function setUserAuthInfo()
    {
        $_SERVER['SSL_CLIENT_S_DN'] = 'GN=Mari-Liis/SN=Männik/serialNumber=47101010033/C=EST';
    }

    public function testIsSuccessfulReturnsFalse()
    {
        $this->assertFalse(Authentication::isSuccessful());
    }

    public function testIsSuccessfulReturnsTrue()
    {
        $this->setSuccess();

        $this->assertTrue(Authentication::isSuccessful());
    }

    /**
     * @expectedException \BitWeb\IdServices\Authentication\Exception\AuthenticationException
     */
    public function testLoginThrowsWhenAuthNotSuccessful()
    {
        Authentication::login();
    }

    /**
     * @expectedException \BitWeb\IdServices\Authentication\Exception\AuthenticationException
     */
    public function testGetLoggedInUserFailsWhenAuthNotSuccessful()
    {
        Authentication::getLoggedInUser();
    }

    public function testGetLoggedInUserReturnsIdCardUser()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();

        Authentication::login();

        $user = Authentication::getLoggedInUser();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Mari-Liis', $user->getFirstName());
        $this->assertEquals('Männik', $user->getLastName());
        $this->assertEquals('47101010033', $user->getSocialSecurityNumber());
        $this->assertEquals('EST', $user->getCountry());

        $this->assertInstanceOf(User::class, unserialize($_SESSION[Authentication::ID_CARD_USER_AUTH_SESSION_KEY]));
    }

    public function testIsUserLoggedIn()
    {
        $this->assertFalse(Authentication::isUserLoggedIn());

        $this->setSuccess();
        $this->setUserAuthInfo();

        Authentication::login();

        $this->assertTrue(Authentication::isUserLoggedIn());
    }

    /**
     * @expectedException \BitWeb\IdServices\Authentication\Exception\AuthenticationException
     */
    public function testLogoutThrowsWhenUserNotLoggedIn()
    {
        Authentication::logout();
    }

    public function testLogout()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();

        Authentication::login();
        Authentication::logout();

        $this->assertFalse(isset($_SESSION[Authentication::ID_CARD_USER_AUTH_SESSION_KEY]));
    }
}
