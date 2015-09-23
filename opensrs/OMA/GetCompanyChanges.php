<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: get_company_changes
// Retrieve a summary of changes to a company  

class GetCompanyChanges
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('get_company_changes', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['company'])) {
            throw new Exception('oSRS Error - Company required');
        }

        return true;
    }
}
