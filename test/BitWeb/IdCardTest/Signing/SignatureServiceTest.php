<?php

namespace BitWeb\IdCardTest\Signing;

use BitWeb\IdCard\Authentication\IdCardAuthentication;
use BitWeb\IdCard\Signing\SignatureService;

class SignatureServiceTest extends \PHPUnit_Framework_TestCase
{
    public $testFileName = 'test/BitWeb/IdCardTest/TestAsset/test.txt';

    protected function setSuccess()
    {
        $_SERVER[IdCardAuthentication::SSL_CLIENT_VERIFY] = IdCardAuthentication::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }

    protected function setUserAuthInfo()
    {
        $_SERVER['SSL_CLIENT_S_DN'] = 'GN=Mari-Liis/SN=Männik/serialNumber=47101010033/C=EST';
    }

    public function testStartSession()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();
        IdCardAuthentication::login();

        $service = new SignatureService();
        $service->setWsdl();
        $service->initSoap();
        $this->assertTrue(is_int($service->startSession($this->testFileName)));
        $this->assertEquals('https://www.openxades.org:9443/?wsdl', $service->getWsdl());
    }

    public function testStartServiceDoesAutomaticLogin()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();

        $service = new SignatureService();
        $service->setWsdl();
        $service->initSoap();
        $this->assertTrue(is_int($service->startSession($this->testFileName)));
    }
} 