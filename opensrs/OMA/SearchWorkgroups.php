<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: search_workgroup
// Retrieve a list of workgroups in a domain. 	

class SearchWorkgroups
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('search_workgroups', $data);
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
