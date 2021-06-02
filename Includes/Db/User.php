<?php
namespace Includes\Db;

use Includes\Db\Query;
use Includes\Helpers\User as HelpersUser;

class User extends Query
{
    protected $table = 'users';
    protected $currentUserId;

    public static function fetchDetailsBeforeCheckout()
    {
        $userId = HelpersUser::getCurrentUserId();
        $user = new User();
        $response  = [];

        $sql = sprintf(
            "SELECT u.`email`,u.`first_name`,u.`last_name`,u.`contact_number`,
                a.`address`,a.`postal_code`,a.`city`,a.`state`,a.`country`,
                a.`landmark` 
                FROM `users` u 
                LEFT JOIN 
                `addresses` a 
                ON 
                u.`id`=a.`user_id` 
                WHERE u.`id`= %d",
            $userId
        );

        $result = $user->rawQuery($sql);
 
        if (empty($result)) {
            return $response;
        }
        
        while ($row = $result->fetch_assoc()) {
            $response = [...$response,$row];
        }
        return $response;
    }
}
