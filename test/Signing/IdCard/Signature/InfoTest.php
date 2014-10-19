<?php

namespace BitWeb\IdServicesTest\Signing\IdCard\Signature;

use BitWeb\IdServices\Signing\IdCard\ConfirmationInfo;
use BitWeb\IdServices\Signing\IdCard\Error;
use BitWeb\IdServices\Signing\IdCard\Signature\Info;
use BitWeb\IdServices\Signing\IdCard\Signature\ProductionPlace;
use BitWeb\IdServices\Signing\IdCard\Signer\Info as SignerInfo;
use BitWeb\IdServices\Signing\IdCard\Signer\Role;

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
        $signer = new SignerInfo();
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
