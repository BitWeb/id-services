<?php

namespace BitWeb\IdServices\Authentication\MobileID;

use BitWeb\IdServices\AbstractService;
use BitWeb\IdServices\Authentication\Exception\AuthenticationException;
use BitWeb\IdServices\Authentication\Exception\ValidationException;

class AuthenticationService extends AbstractService
{
    public function mobileAuthenticate($personalCode, $phoneNumber, $language, $serviceName, $displayMessage)
    {
        $this->validatePersonalCode($personalCode);
        $this->validatePhoneNumber($phoneNumber);
        $this->validateLanguage($language);
        $this->validateServiceName($serviceName);
        $this->validateDisplayMessage($displayMessage);

        try {
            $result = $this->soap->MobileAuthenticate(
                $personalCode,
                'EE',
                $phoneNumber,
                $language,
                $serviceName,
                $displayMessage,
                $this->generateRandomHexString(20),
                'asynchClientServer'
            );
            if (array_key_exists('Status', $result) && $result['Status'] === 'OK') {
                // @todo return object with all response data
                return $result;
            } else {
                throw new AuthenticationException($result['Status']);
            }
        } catch (\SoapFault $e) {
            $this->catchSoapError($e);
        }
    }

    protected function validatePersonalCode($personalCode)
    {
        if (strlen($personalCode) !== 11 || !is_numeric($personalCode)) {
            throw ValidationException::invalidPersonalCode($personalCode);
        }
    }

    protected function validatePhoneNumber($phoneNumber)
    {
        if (strlen($phoneNumber) < 11 || strlen($phoneNumber) > 12) {
            throw ValidationException::invalidPhoneNumber($phoneNumber);
        }
    }

    protected function validateLanguage($language)
    {
        $validLanguages = ['EST', 'ENG', 'RUS', 'LIT'];

        if (!in_array($language, $validLanguages)) {
            throw ValidationException::invalidLanguage($language, $validLanguages);
        }
    }

    protected function validateServiceName($serviceName)
    {
        if (strlen($serviceName) > 20) {
            throw ValidationException::invalidServiceNameLength(strlen($serviceName), 20);
        }
    }

    protected function validateDisplayMessage($displayMessage)
    {
        if (strlen($displayMessage) > 40) {
            throw ValidationException::invalidDisplayMessageLength(strlen($displayMessage), 40);
        }
    }

    /**
     * @todo move to bitweb/stdlib StringUtil
     *
     * @param  int $length
     * @return string
     */
    public function generateRandomHexString($length)
    {
        return bin2hex(openssl_random_pseudo_bytes($length / 2));
    }
}
