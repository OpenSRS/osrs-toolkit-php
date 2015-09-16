<?php

use OpenSRS\domains\lookup\BelongsToRsp;
/**
 * @group lookup
 * @group BelongsToRsp
 */
class BelongsToRspTest extends PHPUnit_Framework_TestCase
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
            'func' => 'lookupBelongsToRsp',
            'data' => (object) array (
                // 'domain' => 'hockey.com'
                ),
            );

        $this->setExpectedException('OpenSRS\Exception');
        $ns = new BelongsToRsp('array', $data);

        $this->assertTrue( $ns instanceof BelongsToRsp );
    }
}
