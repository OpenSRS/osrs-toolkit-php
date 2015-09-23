<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_domain_changes
// Retrieve a summary of changes to a domain 

class GetDomainChanges
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('get_domain_changes', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['domain'])) {
            throw new Exception('oSRS Error - Domain required');
        }

        return true;
    }
}
