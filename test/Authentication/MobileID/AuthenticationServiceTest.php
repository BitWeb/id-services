<?php

namespace BitWeb\IdServicesTest\Authentication\MobileID;

use BitWeb\IdServices\Authentication\MobileID\AuthenticationService;

class AuthenticationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateRandomHexString()
    {
        $authService = new AuthenticationService();

        $this->assertEquals(2, strlen($authService->generateRandomHexString(2)));
        $this->assertEquals(100, strlen($authService->generateRandomHexString(100)));
        $this->assertEquals(1000, strlen($authService->generateRandomHexString(1000)));

        $generated = [];
        for ($i = 0; $i < 1000; $i++) {
            $generated[] = $authService->generateRandomHexString(200);
        }

        for ($n = 0; $n < 1000; $n++) {
            $this->assertFalse(in_array($authService->generateRandomHexString(200), $generated));
        }
    }
}
