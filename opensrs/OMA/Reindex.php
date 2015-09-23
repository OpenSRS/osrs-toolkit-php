<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: reindex
// Reindexes a user's mail folder(s) 

class Reindex
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('reindex', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['user']) || empty($data['id']) || empty($data['folder'])) {
            throw new Exception('oSRS Error - User/IDs required');
        } else {
            return true;
        }
    }
}
