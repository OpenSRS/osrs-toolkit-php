<?php

use OpenSRS\domains\lookup\AllInOneDomain;
/**
 * @group lookup
 * @group AllInOneDomain
 */
class AllInOneDomainTest extends PHPUnit_Framework_TestCase
{
    /**
     * New NameSuggest should throw an exception if 
     * data->domain is ommitted 
     * 
     * @return void
     */
    public function testValidateMissingDomainList()
    {
        $data = (object) array (
            'func' => 'lookupAllInOneDomain',
            'data' => (object) array (
                // 'domain' => 'hockey.com'
                ),
            );

        $this->setExpectedException('OpenSRS\Exception');
        $ns = new AllInOneDomain('array', $data);

        $this->assertTrue( $ns instanceof AllInOneDomain );
    }
}
