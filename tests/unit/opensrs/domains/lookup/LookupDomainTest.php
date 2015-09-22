<?php

use OpenSRS\domains\lookup\LookupDomain;
/**
 * @group LookupDomain
 */
class LookupDomainTest extends PHPUnit_Framework_TestCase
{
    /**
     * New LookupDomain should throw an exception if 
     * data->domain is ommitted 
     * 
     * @return void
     */
    public function testValidateMissingDomain()
    {
        $data = (object) array (
            'func' => 'lookupDomain',
            'attributes' => (object) array (
                 // 'domain' => 'hockey.com',
            ),
        );

        $this->setExpectedException('OpenSRS\Exception');
        $ld = new LookupDomain('array', $data);
    }
}
