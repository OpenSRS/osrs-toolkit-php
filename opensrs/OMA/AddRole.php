<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: add_role
// Add a role to a user.

class AddRole
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('add_role', $data);
        }
    }

    public static function validate($data)
    {
        $roles = array('company', 'domain', 'mail', 'workgroup');
        if (empty($data['role']) || !in_array($data['role'], $roles)) {
            throw new Exception('oSRS Error - No role found');

            return false;
        }
        if (empty($data['user']) || empty($data['object'])) {
            throw new Exception('oSRS Error - User/Role/Object required');

            return false;
        }

        return true;
    }
}
