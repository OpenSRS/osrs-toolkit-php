<?php

use OpenSRS\domains\lookup\LookupDomain;

class LookupDomainIntegrationTest extends PHPUnit_Framework_TestCase
{

    /**
     * Should be able to do a lookup on google.com 
     * 
     * 
     * @return void
     */
    public function testlookupGoogle()
    {
        $data = (object) array (
            'func' => 'premiumDomain',
            'data' => (object) array (
                'domain' => 'google.com',
                'selected' => '.com',
            ),
        );

        $ld = new LookupDomain('array', $data);
        $this->assertEquals($ld->resultRaw[0]['status'], 'taken');
    }
}
