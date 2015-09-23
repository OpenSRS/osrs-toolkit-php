<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_user
// Retrieve the settings and other information for a user

class DeleteDomain
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('delete_domain', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['domain'])) {
            throw new Exception('oSRS Error - Domain required');
        }

        return true;
    }
}
