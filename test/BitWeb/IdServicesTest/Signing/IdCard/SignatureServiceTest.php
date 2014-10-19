<?php

namespace BitWeb\IdServicesTest\Signing\IdCard;


use BitWeb\IdServices\Authentication\IdCard\Authentication;
use BitWeb\IdServices\Signing\IdCard\SignatureService;

class SignatureServiceTest extends \PHPUnit_Framework_TestCase
{
    public $testFileName = 'test/BitWeb/IdServicesTest/TestAsset/test.txt';

    protected function setSuccess()
    {
        $_SERVER[Authentication::SSL_CLIENT_VERIFY] = Authentication::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }

    protected function setUserAuthInfo()
    {
        $_SERVER[Authentication::SSL_CLIENT] = 'GN=Mari-Liis/SN=Männik/serialNumber=47101010033/C=EST';
    }

    public function testStartSession()
    {
        $this->setSuccess();
        $this->setUserAuthInfo();
        Authentication::login();

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
