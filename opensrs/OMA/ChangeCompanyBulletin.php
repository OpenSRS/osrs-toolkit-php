<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: change_company_bulletin
// Create, edit or delete a company bulletin. 	

class ChangeCompanyBulletin
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('change_company_bulletin', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['company']) || empty($data['bulletin']) || empty($data['type']) || empty($data['bulletin_text'])) {
            throw new Exception('oSRS Error - Domain/Bulletin/Type/Bulletin Text required');
        } else {
            if (!in_array(strtolower($data['type']), array('auto', 'manual'))) {
                throw new Exception('oSRS Error - Type supports auto or manual only');
            }

            return true;
        }
    }
}
