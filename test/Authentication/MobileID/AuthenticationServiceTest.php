<?php

namespace BitWeb\IdServicesTest\Authentication\MobileID;

use BitWeb\IdServices\Authentication\MobileID\AuthenticateResponse;
use BitWeb\IdServices\Authentication\MobileID\AuthenticateStatusResponse;
use BitWeb\IdServices\Authentication\MobileID\AuthenticationService;

class AuthenticationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AuthenticationService
     */
    protected $service;

    protected function setUp()
    {
        $this->service = new AuthenticationService();
        $this->service->setWsdl()->initSoap();

        parent::setUp();
    }

    public function testMobileAuthenticateSuccess()
    {
        $response = $this->service->mobileAuthenticate('11412090004', '+37200000766', 'EST', 'Testimine', 'Testimine');

        $this->assertInstanceOf(AuthenticateResponse::class, $response);
        $this->assertEquals(4, strlen($response->getChallengeID()));
        $this->assertTrue(is_int($response->getSessCode()));
    }

    /**
     * @expectedException \BitWeb\IdServices\Exception\ServiceException
     * @expectedExceptionCode 303
     */
    public function testMobileAuthenticationFailOnMobileIDNotActivated()
    {
        $this->service->mobileAuthenticate('38002240211', '+37200001', 'EST', 'Testimine', 'Testimine');
    }

    /**
     * @expectedException \BitWeb\IdServices\Exception\ServiceException
     * @expectedExceptionCode 302
     */
    public function testMobileAuthenticationFailOnCertificatesRevoked()
    {
        $this->service->mobileAuthenticate('14212128027', '+37200009', 'EST', 'Testimine', 'Testimine');
    }

    public function testGetMobileAuthenticateStatusSuccess()
    {
        $response = $this->service->mobileAuthenticate('11412090004', '+37200000766', 'EST', 'Testimine', 'Testimine');

        $this->assertInstanceOf(AuthenticateStatusResponse::class, $this->service->getMobileAuthenticateStatus($response->getSessCode(), false));
    }

    /**
     * @expectedException \BitWeb\IdServices\Exception\ServiceException
     * @expectedExceptionCode 101
     */
    public function testGetMobileAuthenticateStatusFault()
    {
        $this->service->getMobileAuthenticateStatus('', false);
    }
}
