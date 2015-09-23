<?php

use opensrs\domains\lookup\GetBalance;

/**
 * @group lookup
 * @group GetBalance
 */
class GetBalanceTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'lookupGetBalance';

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

        $ns = new GetBalance('array', $data);

        $this->assertTrue($ns instanceof GetBalance);
    }
}
