<?php

namespace BitWeb\IdServicesTest\Authentication\MobileID;

use BitWeb\IdServices\Authentication\MobileID\AuthenticateResponse;
use BitWeb\IdServices\Authentication\MobileID\AuthenticationService;
use BitWeb\IdServices\Exception\ServiceException;

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
        $response = $this->service->mobileAuthenticate('51001091072', '+37260000007', 'EST', 'Testimine', 'Testimine');

        $this->assertInstanceOf(AuthenticateResponse::class, $response);
        $this->assertEquals(4, strlen($response->getChallengeID()));
        $this->assertTrue(is_int($response->getSessCode()));
    }

    /**
     * @expectedException \BitWeb\IdServices\Exception\ServiceException
     */
    public function testMobileAuthenticationFailOnMobileIDNotActivated()
    {
        try {
            $this->service->mobileAuthenticate('38002240211', '+37200001', 'EST', 'Testimine', 'Testimine');
        } catch (ServiceException $e) {
            $this->assertEquals(303, $e->getCode());
            throw $e;
        }
    }

    /**
     * @expectedException \BitWeb\IdServices\Exception\ServiceException
     */
    public function testMobileAuthenticationFailOnCertificatesRevoked()
    {
        try {
            $result = $this->service->mobileAuthenticate('14212128027', '+37200009', 'EST', 'Testimine', 'Testimine');
            var_dump($result);
        } catch (ServiceException $e) {
            $this->assertEquals(302, $e->getCode());
            throw $e;
        }
    }
}
