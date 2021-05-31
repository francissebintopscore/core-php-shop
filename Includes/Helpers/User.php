<?php
namespace Includes\Helpers;

class User
{

    public static function userLoggedIn(){
        
        if( isset( $_SESSION['user_data'] ) && $_SESSION['user_data'] !== '' )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function getCurrentUserId(){

        if( isset( $_SESSION['user_data'] ) && $_SESSION['user_data'] !== '' )
        {
            return $_SESSION['user_data']['id'];
        }

        return 0;
    }
}
