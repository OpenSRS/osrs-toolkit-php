<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_deleted_messages
// Retrieve a list of recoverable deleted emails belonging to a user  	

class GetDeletedMessages
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('get_deleted_messages', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['user'])) {
            throw new Exception('oSRS Error - User required');
        }

        return true;
    }
}
