<?php

use opensrs\domains\forwarding\ForwardingDelete;

/**
 * @group forwarding
 * @group ForwardingDelete
 */
class ForwardingDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdDelete';

    protected $validSubmission = array(
        'data' => array(
            /*
             * Optional
             *
             * domain: domain for which you want
             *   to enable forwarding
             */
            'domain' => '',
            ),
        );

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

        $data->data->domain = 'phptest'.time().'.com';

        $ns = new ForwardingDelete('array', $data);

        $this->assertTrue($ns instanceof ForwardingDelete);
    }
}
