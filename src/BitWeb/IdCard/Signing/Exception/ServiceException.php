<?php

namespace BitWeb\IdCard\Signing\Exception;

class ServiceException extends SigningException
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
}