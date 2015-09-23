<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: post_company_bulletin
// Send a bulletin to all users in all domains in the domain. 

class PostCompanyBulletin
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('post_company_bulletin', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['company']) || empty($data['bulletin']) || empty($data['type'])) {
            throw new Exception('oSRS Error - Company/Bulletin/Type required');
        } else {
            if (!in_array(strtolower($data['type']), array('auto', 'manual'))) {
                throw new Exception('oSRS Error - Type supports auto or manual only');
            }

            return true;
        }
    }
}
