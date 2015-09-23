<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: search_domains
// Retrieve a list of domains in a company. 

class SearchDomains
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('search_domains', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['criteria']['company'])) {
            throw new Exception('oSRS Error - Company required');
        } else {
            return true;
        }
    }
}
