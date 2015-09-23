<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: delete_user
// Delete a user. Once a user is deleted this user will no longer be able to receive mail or access the system in any way. 

class DeleteUser
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('delete_user', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['user'])) {
            throw new Exception('oSRS Error - User required');
        }

        return true;
    }
}
