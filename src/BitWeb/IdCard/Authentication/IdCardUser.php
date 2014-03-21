<?php

namespace BitWeb\IdCard\Authentication;

/**
 *
 *
 * @author Tõnis Tobre <tobre@bitweb.ee>
 * @copyright Copyright (C) 2009. All rights reserved.
 *
 * Change log:
 * Date            User            Comment
 * ---------------------------------------------
 * Apr 2, 2009    tobre            Initial version
 *
 */
class IdCardUser
{

    private $firstName;
    private $lastName;
    private $socialSecurityNumber;
    private $country;

    public function __construct($firstName = null, $lastName = null, $socialSecurityNumber = null, $country = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->socialSecurityNumber = $socialSecurityNumber;
        $this->country = $country;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setSocialSecurityNumber($socialSecurityNumber)
    {
        $this->socialSecurityNumber = $socialSecurityNumber;
        return $this;
    }

    public function getSocialSecurityNumber()
    {
        return $this->socialSecurityNumber;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }
}