<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_user_folder
// Get a list of a user's folders and deleted folders. 

class GetUserFolders
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('get_user_folders', $data);
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
