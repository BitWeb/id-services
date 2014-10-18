<?php

namespace BitWeb\IdCardTest\UseCase;

use BitWeb\IdCard\Authentication\IdCardAuthentication;
use BitWeb\IdCard\Signing\SignatureService;

class SigningTest extends \PHPUnit_Framework_TestCase
{
    public $testFileName = 'test/BitWeb/IdCardTest/TestAsset/test.txt';

    protected function setSuccess()
    {
        $_SERVER[IdCardAuthentication::SSL_CLIENT_VERIFY] = IdCardAuthentication::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }

    protected function setUserAuthInfo()
    {
        $_SERVER[IdCardAuthentication::SSL_CLIENT] = $this->getConfig()['authenticate']['info'];
    }

    protected function getConfig()
    {
        if (is_file('test/BitWeb/IdCardTest/TestAsset/config.php')) {
            return include 'test/BitWeb/IdCardTest/TestAsset/config.php';
        }

        return include 'test/BitWeb/IdCardTest/TestAsset/config.dist.php';
    }

    public function testSigningProcess()
    {
        if ($this->getConfig()['signature']['hex'] === null) {
            $this->markTestSkipped('Test skipped, because no config was found.');
        }

        // login
        $this->setSuccess();
        $this->setUserAuthInfo();
        IdCardAuthentication::login();

        // start session
        $service = new SignatureService();
        $service->setWsdl();
        $service->initSoap();
        $sessionCode = $service->startSession($this->testFileName);

        // prepare
        $certificateConfig = $this->getConfig()['certificate'];
        $info = $service->prepareSignature($sessionCode, $certificateConfig['id'], $certificateConfig['hex']);

        //finalize
        $info2 = $service->finalizeSignature($sessionCode, $info['SignatureId'], $this->getConfig()['signature']['hex']);
    }
}
