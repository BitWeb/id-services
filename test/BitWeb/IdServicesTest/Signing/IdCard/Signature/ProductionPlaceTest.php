<?php

namespace BitWeb\IdServicesTest\Signing\IdCard\Signature;

use BitWeb\IdServices\Signing\IdCard\Signature\ProductionPlace;

class ProductionPlaceTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf(ProductionPlace::class, new ProductionPlace());
    }

    public function testSettersAndGetters()
    {
        $city = 'Tartu';
        $stateOrProvince = 'Tartumaa';
        $postalCode = '50110';
        $countryName = 'Estonia';

        $productionPlace = new ProductionPlace();
        $productionPlace->setCity($city);
        $productionPlace->setStateOrProvince($stateOrProvince);
        $productionPlace->setPostalCode($postalCode);
        $productionPlace->setCountryName($countryName);

        $this->assertEquals($city, $productionPlace->getCity());
        $this->assertEquals($stateOrProvince, $productionPlace->getStateOrProvince());
        $this->assertEquals($postalCode, $productionPlace->getPostalCode());
        $this->assertEquals($countryName, $productionPlace->getCountryName());
    }
}
