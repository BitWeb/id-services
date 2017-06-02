<?php

namespace BitWeb\IdServices\Authentication\MobileID;

use BitWeb\IdServices\AbstractService;
use BitWeb\IdServices\Authentication\Exception\AuthenticationException;
use BitWeb\IdServices\Authentication\Exception\ValidationException;
use BitWeb\IdServices\Exception\ServiceException;
use Zend\Log\Logger;
use Zend\Hydrator\ClassMethods;

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
        $this->throwIfSoapNotInitialized();

        $this->log(Logger::INFO, '')->log(Logger::INFO, 'SOAP::MobileAuthenticate start validation');
        $this->validatePersonalCode($personalCode);
        $this->validatePhoneNumber($phoneNumber);
        $this->validateLanguage($language);
        $this->validateServiceName($serviceName);
        $this->validateDisplayMessage($displayMessage);
        $this->log(Logger::INFO, 'SOAP::MobileAuthenticate input validation finished');

        try {
            $data = [
                'IDCode'           => $personalCode,
                'CountryCode'      => self::COUNTRY_CODE_ESTONIA,
                'PhoneNo'          => $phoneNumber,
                'Language'         => $language,
                'ServiceName'      => $serviceName,
                'MessageToDisplay' => $displayMessage,
                'SPChallenge'      => $this->generateRandomNumbers(20),
                'MessagingMode'    => 'asynchClientServer'
            ];

            $this->log(Logger::INFO, $this->wsdl . ' SOAP::MobileAuthenticate request: ' . serialize($data));
            $result = $this->soap->call('MobileAuthenticate', $data);
            $this->log(Logger::INFO, $this->wsdl . ' SOAP::MobileAuthenticate response status ' . serialize($result));

            $status = $result['Status'];
            if (in_array($status, ['OK', 'USER_AUTHENTICATED'])) {
                return $this->getHydrator()->hydrate($result, new AuthenticateResponse());
            } else {
                throw new AuthenticationException($status);
            }
        } catch (\SoapFault $e) {
            $this->log(Logger::ERR, 'SOAP::MobileAuthenticate exception: ' . $e->getMessage());
            throw $this->soapError($e);
        } catch (\Exception $e) {
            $this->log(Logger::ERR, 'SOAP::MobileAuthenticate exception: ' . $e->getMessage());
            if (!$e instanceof AuthenticationException) {
                throw new AuthenticationException('Unknown exception has occurred.', null, $e);
            }

            throw $e;
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
        $this->throwIfSoapNotInitialized();

        $this->log(Logger::INFO, '')->log(Logger::INFO, 'SOAP::GetMobileAuthenticateStatus start validation');
        if (!is_bool($waitSignature)) {
            throw ValidationException::invalidValue('WaitSignature', is_object($waitSignature) ? get_class($waitSignature) : gettype($waitSignature), 'boolean');
        }
        $this->log(Logger::INFO, 'SOAP::GetMobileAuthenticateStatus input validation finished');

        try {
            $data = [
                'Sesscode'      => $sessionCode,
                'WaitSignature' => $waitSignature
            ];

            $this->log(Logger::INFO, 'SOAP::GetMobileAuthenticateStatus request: ' . serialize($data));
            $result = $this->soap->call('GetMobileAuthenticateStatus', $data);
            $this->log(Logger::INFO, 'SOAP::GetMobileAuthenticateStatus response: ' . serialize($result));

            return $this->getHydrator()->hydrate($result, new AuthenticateStatusResponse());
        } catch (\SoapFault $e) {
            $this->log(Logger::ERR, 'SOAP::GetMobileAuthenticateStatus exception: ' . $e->getMessage());
            throw $this->soapError($e);
        } catch (\Exception $e) {
            $this->log(Logger::ERR, 'SOAP::GetMobileAuthenticateStatus exception: ' . $e->getMessage());
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
        $min = 'https://tsp.demo.sk.ee/?wsdl' === $this->wsdl ? 9 : 11;
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
