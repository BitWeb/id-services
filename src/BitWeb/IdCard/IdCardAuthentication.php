<?php

namespace BitWeb\IdCard;

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
class IdCardAuthentication extends Authentication
{

    const SSL_CLIENT_VERIFY = 'SSL_CLIENT_VERIFY';
    const SSL_CLIENT_VERIFY_SUCCESSFUL = 'SUCCESS';

    public function isSuccessful()
    {
        return isset($_SERVER[self::SSL_CLIENT_VERIFY]) && $_SERVER[self::SSL_CLIENT_VERIFY] == self::SSL_CLIENT_VERIFY_SUCCESSFUL;
    }


    public function getUser()
    {
        if (!$this->isSuccessful()) {
            throw new AuthenticationException('User not logged in');
        }

        $cardInfo = explode('/', $_SERVER['SSL_CLIENT_S_DN']);

        $parameters = array();
        foreach ($cardInfo as $info) {
            if ($info != null) {
                $parameterArray = explode('=', $info);
                $parameters[$parameterArray[0]] = $this->decodeToUtf8($parameterArray[1]);
            }
        }

        $user = new IdCardUser();
        $user->setFirstName($parameters['GN']);
        $user->setLastName($parameters['SN']);
        $user->setSocialSecuritynumber($parameters['serialNumber']);
        $user->setCountry($parameters['C']);

        return $user;
    }

    /**
     * Decodes id-card information to utf8
     *
     * @param String $str String to decode
     * @return String Decoded string
     */
    private function decodeToUtf8($str)
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
}
