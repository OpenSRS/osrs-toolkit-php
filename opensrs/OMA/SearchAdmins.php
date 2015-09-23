<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: search_domain
// Retrieve a list of admins in a company. 

class SearchAdmins
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('search_admins', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (!empty($data['criteria']['type'])) {
            foreach ($data['criteria']['type'] as $type) {
                if (!in_array(strtolower($type), array('company', 'company_view', 'domain', 'mail', 'workgroup'))) {
                    throw new Exception('oSRS Error - one or more of company, company_view, domain, mail, and workgroup required');

                    return false;
                }
            }
        }

        return true;
    }
}
