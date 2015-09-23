<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_company_bulletin
// Retrieve the text of a company bulletin. 	

class GetCompanyBulletin
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('get_company_bulletin', $data);
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
        }

        return true;
    }
}
