<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: change_domain
// Create a new domain or change the attributes of an existing domain. 	

class ChangeDomainBulletin
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('change_domain_bulletin', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['domain']) || empty($data['bulletin']) || empty($data['type']) || empty($data['bulletin_text'])) {
            throw new Exception('oSRS Error - Company/Bulletin/Type/Bulletin Text required');
        }

        return true;
    }
}
