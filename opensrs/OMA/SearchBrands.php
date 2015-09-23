<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

// command: search_brands
// Retrieve a list of brands in a company matching a given criteria 	

class SearchBrands
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('search_brands', $data);
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
