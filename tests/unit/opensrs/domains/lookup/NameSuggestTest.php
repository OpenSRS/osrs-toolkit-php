<?php

use OpenSRS\domains\lookup\NameSuggest;
/**
 * @group lookup
 * @group NameSuggest
 */
class NameSuggestTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'lookupNameSuggest';

    /**
     * New NameSuggest should throw an exception if 
     * data->domain is ommitted 
     * 
     * @return void
     */
    public function testValidateMissingDomain()
    {
        $data = (object) array (
            'data' => (object) array (
                // 'domain' => 'hockey.com'
                ),
            );

        $this->setExpectedException('OpenSRS\Exception');
        $ns = new NameSuggest('array', $data);
    }
}
