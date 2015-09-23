<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: move_user_messages
// Move user messages to a different folder. 

class MoveUserMessages
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('move_user_messages', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['user']) || empty($data['ids'])) {
            throw new Exception('oSRS Error - User/IDs required');
        }

        return true;
    }
}
