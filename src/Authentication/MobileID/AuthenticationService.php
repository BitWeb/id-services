<?php

namespace BitWeb\IdServices\Authentication\MobileID;

use BitWeb\IdServices\AbstractService;
use BitWeb\IdServices\Authentication\Exception\AuthenticationException;
use BitWeb\IdServices\Authentication\Exception\ValidationException;
use BitWeb\IdServices\Exception\ServiceException;
use Zend\Stdlib\Hydrator\ClassMethods;

class AuthenticationService extends AbstractService
{
    const COUNTRY_CODE_ESTONIA = 'EE';

    const LANGUAGE_ESTONIAN   = 'EST';
    const LANGUAGE_ENGLISH    = 'ENG';
    const LANGUAGE_LITHUANIAN = 'LIT';
    const LANGUAGE_RUSSIAN    = 'RUS';

    protected static $languageCodes = [
        self::LANGUAGE_ESTONIAN,
        self::LANGUAGE_ENGLISH,
        self::LANGUAGE_LITHUANIAN,
        self::LANGUAGE_RUSSIAN
    ];

    /**
     * @param  string $personalCode
     * @param  string $phoneNumber
     * @param  string $language
     * @param  string $serviceName
     * @param  string $displayMessage
     * @return AuthenticateResponse on successful query.
     * @throws AuthenticationException
     * @throws ServiceException
     * @throws ValidationException
     */
    public function mobileAuthenticate($personalCode, $phoneNumber, $language, $serviceName, $displayMessage)
    {
        $this->validatePersonalCode($personalCode);
        $this->validatePhoneNumber($phoneNumber);
        $this->validateLanguage($language);
        $this->validateServiceName($serviceName);
        $this->validateDisplayMessage($displayMessage);

        try {
            $result = $this->soap->call('MobileAuthenticate', [
                'IDCode'           => $personalCode,
                'CountryCode'      => self::COUNTRY_CODE_ESTONIA,
                'PhoneNo'          => $phoneNumber,
                'Language'         => $language,
                'ServiceName'      => $serviceName,
                'MessageToDisplay' => $displayMessage,
                'SPChallenge'      => $this->generateRandomNumbers(20),
                'MessagingMode'    => 'asynchClientServer'
            ]);

            if (array_key_exists('Status', $result) && in_array($result['Status'], ['OK', 'USER_AUTHENTICATED'])) {
                return $this->getHydrator()->hydrate($result, new AuthenticateResponse());
            } else {
                throw new AuthenticationException($result['Status']);
            }
        } catch (\SoapFault $e) {
            throw $this->soapError($e);
        } catch (\Exception $e) {
            throw new AuthenticationException('Unknown exception has occurred.', null, $e);
        }
    }

    /**
     * @param  string  $sessionCode
     * @param  boolean $waitSignature
     * @return AuthenticateStatusResponse
     * @throws AuthenticationException
     * @throws ServiceException
     * @throws ValidationException
     */
    public function getMobileAuthenticateStatus($sessionCode, $waitSignature)
    {
        if (!is_bool($waitSignature)) {
            throw ValidationException::invalidValue('WaitSignature', is_object($waitSignature) ? get_class($waitSignature) : gettype($waitSignature), 'boolean');
        }

        try {
            $result = $this->soap->call('GetMobileAuthenticateStatus', [
                'SessCode'      => $sessionCode,
                'WaitSignature' => $waitSignature
            ]);

            return $this->getHydrator()->hydrate($result, new AuthenticateStatusResponse());
        } catch (\SoapFault $e) {
            throw $this->soapError($e);
        } catch (\Exception $e) {
            throw new AuthenticationException('Unknown exception has occurred.', null, $e);
        }
    }

    protected function getHydrator()
    {
        return (new ClassMethods())->setUnderscoreSeparatedKeys(false);
    }

    protected function validatePersonalCode($personalCode)
    {
        if (strlen($personalCode) !== 11 || !is_numeric($personalCode)) {
            throw ValidationException::invalidPersonalCode($personalCode);
        }
    }

    protected function validatePhoneNumber($phoneNumber)
    {
        if (substr($phoneNumber, 0, 4) !== '+372') {
            throw ValidationException::invalidPhoneNumber($phoneNumber);
        }

        // allow shorter numbers for UnitTests and testing
        $min = 'https://www.openxades.org:9443/?wsdl' === $this->wsdl ? 9 : 11;
        if (strlen($phoneNumber) < $min || strlen($phoneNumber) > 12) {
            throw ValidationException::invalidPhoneNumber($phoneNumber, $min);
        }
    }

    protected function validateLanguage($language)
    {
        if (!in_array($language, self::$languageCodes)) {
            throw ValidationException::invalidLanguage($language, self::$languageCodes);
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

    protected function generateRandomNumbers($length)
    {
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= mt_rand(0, 9);
        }

        return $string;
    }
}
