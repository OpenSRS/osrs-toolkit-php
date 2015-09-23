<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_deleted_contacts
// Retrieves a list of deleted restorable contacts from a user's wembail address book. 

class GetDeletedContacts
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('get_deleted_contacts', $data);
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
