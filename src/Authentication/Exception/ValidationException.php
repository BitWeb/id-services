<?php

namespace BitWeb\IdServices\Authentication\Exception;

class ValidationException extends AuthenticationException
{
    public static function invalidPersonalCode($personalCode, $chars = 11)
    {
        return new static(
            sprintf('Invalid personal code "%s", expected %s chars and only numbers.', $personalCode, $chars)
        );
    }

    public static function invalidPhoneNumber($phone, $min = 11, $max = 12, $countryCode = '+372')
    {
        return new static(
            sprintf('Invalid phone number "%s", expected %s to %s chars with county code "%s".', $phone, $min, $max, $countryCode)
        );
    }

    public static function invalidLanguage($language, array $languages)
    {
        return new static(
            sprintf('Invalid language "%s", expected one of "%s"', $language, implode('", "', $languages))
        );
    }

    public static function invalidServiceNameLength($length, $maxLength)
    {
        return new static(
            sprintf('Expected service name to be maximum of %s bytes, got %s.', $maxLength, $length)
        );
    }

    public static function invalidDisplayMessageLength($length, $maxLength)
    {
        return new static(
            sprintf('Expected display message to be maximum of %s bytes, got %s.', $maxLength, $length)
        );
    }

    public static function invalidValue($argumentName, $got, $expected)
    {
        return new static(
            sprintf('Expected argument "%s" to be type of "%s", got "%".', $argumentName, $expected, $got)
        );
    }
}
