<?php

namespace BitWeb\IdServicesTest\UseCase;

use BitWeb\IdServices\Authentication\IdCard\Authentication;
use BitWeb\IdServices\Signing\IdCard\SignatureService;

class SigningTest extends \PHPUnit_Framework_TestCase
{
    public $testFileName = 'test/TestAsset/test.txt';

    protected function setSuccess()
    {
        $_SERVER[Authentication::SSL_CLIENT_VERIFY] = Authentication::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }

    protected function setUserAuthInfo()
    {
        $_SERVER[Authentication::SSL_CLIENT] = $this->getConfig()['authenticate']['info'];
    }

    protected function getConfig()
    {
        if (is_file('test/TestAsset/config.php')) {
            return include 'test/TestAsset/config.php';
        }

        return include 'test/TestAsset/config.dist.php';
    }

    public function testSigningProcess()
    {
        if ($this->getConfig()['signature']['hex'] === null) {
            $this->markTestSkipped('Test skipped, because no config was found.');
        }

        // login
        $this->setSuccess();
        $this->setUserAuthInfo();
        Authentication::login();

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
