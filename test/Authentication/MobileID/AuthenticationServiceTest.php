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
        $response = $this->service->mobileAuthenticate('60001019906', '+37200000766', 'EST', 'Testimine', 'Testimine');

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
        $this->service->mobileAuthenticate('60001019928', '+37200000366', 'EST', 'Testimine', 'Testimine');
    }

    /**
     * @expectedException \BitWeb\IdServices\Exception\ServiceException
     * @expectedExceptionCode 302
     */
    public function testMobileAuthenticationFailOnCertificatesRevoked()
    {
        $this->service->mobileAuthenticate('60001019939', '+37200000266', 'EST', 'Testimine', 'Testimine');
    }

    public function testGetMobileAuthenticateStatusSuccess()
    {
        $response = $this->service->mobileAuthenticate('60001019906', '+37200000766', 'EST', 'Testimine', 'Testimine');

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
