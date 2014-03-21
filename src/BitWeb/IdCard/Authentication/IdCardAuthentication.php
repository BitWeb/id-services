<?php

namespace BitWeb\IdCard\Authentication;

/**
 * Id Card authentication.
 *
 * Original version by:
 * @author Tõnis Tobre <tobre@bitweb.ee>
 * @copyright Copyright (C) 2009. All rights reserved.
 */
class IdCardAuthentication extends Authentication
{

    const SSL_CLIENT_VERIFY = 'SSL_CLIENT_VERIFY';
    const SSL_CLIENT_VERIFY_SUCCESSFUL = 'SUCCESS';
    const ID_CARD_USER_AUTH_SESSION_KEY = 'idCardAuth';

    public static function isSuccessful()
    {
        return isset($_SERVER[self::SSL_CLIENT_VERIFY]) && $_SERVER[self::SSL_CLIENT_VERIFY] == self::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }

    public static function login()
    {
        if (!self::isSuccessful()) {
            throw new AuthenticationException('User not authenticated!');
        }

        $cardInfo = explode('/', $_SERVER['SSL_CLIENT_S_DN']);

        $parameters = array();
        foreach ($cardInfo as $info) {
            if ($info != null) {
                $parameterArray = explode('=', $info);
                $parameters[$parameterArray[0]] = self::decodeToUtf8($parameterArray[1]);
            }
        }

        $user = new IdCardUser();
        $user->setFirstName($parameters['GN']);
        $user->setLastName($parameters['SN']);
        $user->setSocialSecuritynumber($parameters['serialNumber']);
        $user->setCountry($parameters['C']);

        self::saveIdCardUserToSession($user);
    }

    public static function getLoggedInUser()
    {
        if (!self::isUserLoggedIn()) {
            throw new AuthenticationException('User not logged in');
        }

        return unserialize($_SESSION[self::ID_CARD_USER_AUTH_SESSION_KEY]);
    }

    /**
     * Decodes id-card information to utf8
     *
     * @param String $str String to decode
     * @return String Decoded string
     */
    protected static function decodeToUtf8($str)
    {
        $str = preg_replace_callback("/\\\\x([0-9ABCDEF]{1,2})/", function ($matches) {
            return chr(hexdec($matches[1]));
        }, $str);

        $encoding = mb_detect_encoding($str, 'ASCII, UCS2, UTF8');
        if ($encoding == 'ASCII') {
            $result = mb_convert_encoding($str, 'UTF-8', 'ASCII');
        } else {
            if (substr_count($str, chr(0)) > 0) {
                $result = mb_convert_encoding($str, 'UTF-8', 'UCS2');
            } else {
                $result = $str;
            }
        }

        return $result;
    }

    public static function saveIdCardUserToSession(IdCardUser $idCardUser)
    {
        $_SESSION[self::ID_CARD_USER_AUTH_SESSION_KEY] = serialize($idCardUser);
    }

    public static function isUserLoggedIn()
    {
        if (isset($_SESSION[self::ID_CARD_USER_AUTH_SESSION_KEY]) && unserialize($_SESSION[self::ID_CARD_USER_AUTH_SESSION_KEY]) instanceof IdCardUser) {
            return true;
        }

        return false;
    }

    public static function logout()
    {
        if (!isset($_SESSION[self::ID_CARD_USER_AUTH_SESSION_KEY])) {
            throw new AuthenticationException('User is not logged in.');
        }

        unset($_SESSION[self::ID_CARD_USER_AUTH_SESSION_KEY]);
    }
}
