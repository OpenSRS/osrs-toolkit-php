<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: restore_deleted_messages
// Recover specific recently deleted messages.  

class RestoreDeletedMessages
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('restore_deleted_messages', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['user']) || empty($data['ids'])) {
            throw new Exception('oSRS Error - User/IDs required');
        } else {
            return true;
        }
    }
}
