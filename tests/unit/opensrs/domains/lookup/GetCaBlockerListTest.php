<?php

use opensrs\domains\lookup\GetCaBlockerList;

/**
 * @group lookup
 * @group GetCaBlockerList
 */
class GetCaBlockerListTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'lookupGetCaBlockerList';

    protected $validSubmission = array();

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $ns = new GetCaBlockerList('array', $data);

        $this->assertTrue($ns instanceof GetCaBlockerList);
    }
}
