<?php
namespace Includes\Helpers;

class Security
{
    public static function generateCSRF($tokenName ='token')
    {
        $_SESSION[ $tokenName ] = bin2hex(random_bytes(32));
        return  $_SESSION[ $tokenName ];
    }
    
    public static function validateCSRF($tokenToCheck, $tokenName ='token')
    {
        if (!empty($tokenToCheck)) {
            if (hash_equals($_SESSION[ $tokenName ], $tokenToCheck)) {
                return true;
            }
        }
        return false;
    }
}
