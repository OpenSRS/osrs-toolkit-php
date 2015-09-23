<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: delete_workgroup
// Remove a workgroup from a domain 

class DeleteWorkgroup
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('delete_workgroup', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['domain']) || empty($data['workgroup'])) {
            throw new Exception('oSRS Error - Domain/Workgroup required');
        }

        return true;
    }
}
