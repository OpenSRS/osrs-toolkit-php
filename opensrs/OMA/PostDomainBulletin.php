<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: change_domain
// Create a new domain or change the attributes of an existing domain. 	

class PostDomainBulletin
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('post_domain_bulletin', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['domain']) || empty($data['bulletin']) || empty($data['type'])) {
            throw new Exception('oSRS Error - Domain/Bulletin/Type required');
        } else {
            if (!in_array(strtolower($data['type']), array('auto', 'manual'))) {
                throw new Exception('oSRS Error - Type supports auto or manual only');
            } else {
                return true;
            }
        }
    }
}
