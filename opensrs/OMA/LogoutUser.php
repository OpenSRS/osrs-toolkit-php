<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: logout_user
// Terminate all IMAP and POP sessions the user has active 

class LogoutUser
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('logout_user', $data);
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
