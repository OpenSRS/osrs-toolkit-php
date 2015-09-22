<?php

use OpenSRS\domains\lookup\GetDeletedDomains;
/**
 * @group lookup
 * @group GetDeletedDomains
 */
class GetDeletedDomainsTest extends PHPUnit_Framework_TestCase
{
    protected $func = "lookupGetDeletedDomains";

    protected $validSubmission = array();

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode ($this->validSubmission) );

        $ns = new GetDeletedDomains( 'array', $data );

        $this->assertTrue( $ns instanceof GetDeletedDomains );
    }
}
