<?php

namespace BitWeb\IdCardTest\Signing\Signature;

use BitWeb\IdCard\Signing\ConfirmationInfo;
use BitWeb\IdCard\Signing\Error;
use BitWeb\IdCard\Signing\Signature\Info;
use BitWeb\IdCard\Signing\Signature\ProductionPlace;
use BitWeb\IdCard\Signing\Signer\Role;
use BitWeb\IdCard\Signing\Signer\Info as SignerInfo;

class InfoTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(Info::class, new Info());
    }

    public function textGettersAndSetters()
    {
        $id = 'S0';
        $status = 'OK';
        $error = new Error();
        $signingTime = "";
        $signerRole = new Role();
        $signatureProductionPlace = new ProductionPlace();
        $signer = new \BitWeb\IdCard\Signing\Signer\Info();
        $confirmation = new ConfirmationInfo();
        $timestamps = "";
        $CRLInfo = "";

        $info = new Info();
        $info->setId($id);
        $info->setStatus($status);
        $info->setError($error);
        $info->setSigningTime($signingTime);
        $info->setSignerRole($signerRole);
        $info->setSignatureProductionPlace($signatureProductionPlace);
        $info->setSigner($signer);
        $info->setConfirmation($confirmation);
        $info->setTimestamps($timestamps);
        $info->setCRLInfo($CRLInfo);

        $this->assertEquals($id, $info->getId());
        $this->assertEquals($status, $info->getStatus());
        $this->assertInstanceOf(Error::class, $info->getError());
        $this->assertEquals($signingTime, $info->getSigningTime());
        $this->assertInstanceOf(Role::class, $info->getSignerRole());
        $this->assertInstanceOf(ProductionPlace::class, $info->getSignatureProductionPlace());
        $this->assertInstanceOf(SignerInfo::class, $info->getSigner());
        $this->assertInstanceOf(ConfirmationInfo::class, $info->getConfirmation());
        $this->assertEquals($timestamps, $info->getTimestamps());
        $this->assertEquals($CRLInfo, $info->getCRLInfo());
    }
} 