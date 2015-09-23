<?php

namespace opensrs\OMA;

use opensrs\OMA;

// command: migration_trace
// Retrieve detailed information about a single user in a current or historical migration job. 

class MigrationTrace
{
    public static function call($data)
    {
        if (self::validate($data)) {
            return OMA::send_cmd('migration_trace', $data);
        }
    }

    // Valdation rule here
    public static function validate($data)
    {
        if (empty($data['job']) || empty($data['user'])) {
            throw new Exception('oSRS Error - Job/User required');
        }

        return true;
    }
}
