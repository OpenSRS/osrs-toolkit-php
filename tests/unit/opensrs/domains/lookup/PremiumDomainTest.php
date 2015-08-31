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

    /**
     * Get TLD function should return either the selected tlds,
     * or a default set
     * 
     * @return void
     */
    public function testGetTlds()
    {
        // get included default tlds
        $data = (object) array (
            'func' => 'premiumDomain',
            'data' => (object) array (
                'domain' => 'hockey.com',
            ),
        );

        $pd = new PremiumDomain('array', $data);
        $this->assertTrue(array('.com', '.net', '.org') == $pd->getTlds());

        // get supplied default tlds
        $data->data->defaulttld = '.com;.net';

        $pd = new PremiumDomain('array', $data);
        $this->assertTrue(array('.com', '.net') == $pd->getTlds());


        // get selected tlds
        $data->data->selected = '.com';

        $pd = new PremiumDomain('array', $data);
        $this->assertTrue(array('.com') == $pd->getTlds());
    }
}
