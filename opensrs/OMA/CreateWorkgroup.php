<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: create_workgroup
// Create a workgroup in a domain 

class CreateWorkgroup
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('create_workgroup', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['workgroup']) || empty($data['domain'])) {
            throw new Exception('oSRS Error - Workgroup/Domain required');
        } else {
            return true;
        }
    }
}
