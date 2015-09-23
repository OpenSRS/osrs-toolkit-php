<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_user_attribute_history
// Get historical values for an attribute for a user. 

class GetUserAttributeHistory
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('get_user_attribute_history', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['user']) || empty($data['attribute'])) {
            throw new Exception('oSRS Error - User/Attribute required');
        }

        return true;
    }
}
