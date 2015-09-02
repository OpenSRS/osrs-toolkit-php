<?php

use OpenSRS\domains\lookup\PremiumDomain;

class PremiumDomainTest extends PHPUnit_Framework_TestCase
{
    /**
     * New PremiumDomain should throw an exception if 
     * data->domain is ommitted 
     * 
     * @return void
     */
    public function testValidateMissingDomain()
    {
        $data = (object) array (
            'func' => 'premiumDomain',
            'data' => (object) array (
                // 'domain' => 'hockey.com',
                'selected' => '.com;.net;.org',
                'alldomains' => '.com;.net;.org', 
            ),
        );

        $this->setExpectedException('OpenSRS\Exception');
        $pd = new PremiumDomain('array', $data);
    }
}
