<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: search_users
// Retrieve a list of users in a domain. 

class SearchUsers
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('search_users', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['criteria']['domain'])) {
            throw new Exception('oSRS Error - Domain required');
        } else {
            return true;
        }
    }
}
