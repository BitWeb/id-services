<?php

namespace BitWeb\IdServices\Exception;

class ServiceException extends IdServicesException
{
    const ERROR_CODE_100 = 'General error.';
    const ERROR_CODE_101 = 'Incorrect input values.';
    const ERROR_CODE_102 = 'Required parameter is missing.';
    const ERROR_CODE_103 = 'Unauthorized.';
    const ERROR_CODE_200 = 'Service general error.';
    const ERROR_CODE_201 = 'User\'s certificate is missing.';
    const ERROR_CODE_202 = 'Unable to check certificate validity.';
    const ERROR_CODE_203 = 'Session is locked by another SOAP client.';
    const ERROR_CODE_300 = 'User\'s phone related general error.';
    const ERROR_CODE_301 = 'User doesn\'t have Mobile-ID contract.';
    const ERROR_CODE_302 = 'User\s certificate is revoked.';
    const ERROR_CODE_303 = 'User\'s Mobile-ID is not activated.';
    const ERROR_CODE_304 = 'User\'s certificate is stopped.';
    const ERROR_CODE_305 = 'User\'s certificate has expired.';
    const ERROR_CODE_413 = 'Input message exceeds allowed maximum limit.';
    const ERROR_CODE_503 = 'You have exceeded allowed maximum concurrent requests limit.';

    /**
     * Error codes translated according to http://www.sk.ee/upload/files/DigiDocService_spec_est.pdf version 2.127
     *
     * @var array
     */
    public static $errorCodeMap = [
        '100' => ServiceException::ERROR_CODE_100,
        '101' => ServiceException::ERROR_CODE_101,
        '102' => ServiceException::ERROR_CODE_102,
        '103' => ServiceException::ERROR_CODE_103,
        '200' => ServiceException::ERROR_CODE_200,
        '201' => ServiceException::ERROR_CODE_201,
        '202' => ServiceException::ERROR_CODE_202,
        '203' => ServiceException::ERROR_CODE_203,
        '300' => ServiceException::ERROR_CODE_300,
        '301' => ServiceException::ERROR_CODE_301,
        '302' => ServiceException::ERROR_CODE_302,
        '303' => ServiceException::ERROR_CODE_303,
        '304' => ServiceException::ERROR_CODE_304,
        '305' => ServiceException::ERROR_CODE_305,
        '413' => ServiceException::ERROR_CODE_413,
        '503' => ServiceException::ERROR_CODE_503
    ];

    public static function soapFault(\SoapFault $e)
    {
        $code = $e->getMessage();

        // fix undefined index error in HHVM
        if (!in_array($code, static::$errorCodeMap)) {
            $xml = $e->getMessage();
            $faultString = '<faultstring xml:lang="en">';

            $code = substr($xml, strpos($xml, $faultString) + strlen($faultString), 3);
        }

        $message = static::$errorCodeMap[$code];

        if (isset($e->detail) && isset($e->detail->message)) {
            $message .= ' ' . $e->detail->message;
        }

        return new static($message, (int)$code, $e);
    }
}
