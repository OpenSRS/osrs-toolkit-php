<?php

namespace opensrs\OMA;

use opensrs\OMA;
// command: restore_user
// Restore a deleted user 
use opensrs\Exception;

class RestoreUser
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('restore_user', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['user']) || empty($data['id']) || empty($data['new_name'])) {
            throw new Exception('oSRS Error - User/ID/New Namerequired');
        } else {
            return true;
        }
    }
}
