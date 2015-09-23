<?php

namespace opensrs\OMA;

use opensrs\OMA;
use opensrs\Exception;

class RestoreDomain
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('restore_domain', $data);
        }
    }

    public static function validate($data)
    {
        if (empty($data['domain']) || empty($data['id']) || empty($data['new_name'])) {
            throw new Exception('oSRS Error - Domain/ID/New Namerequired');
        } else {
            return true;
        }
    }
}
