<?php

use opensrs\domains\forwarding\ForwardingCreate;

/**
 * @group forwarding
 * @group ForwardingCreate
 */
class ForwardingCreateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdCreate';

    protected $validSubmission = array(
        'attributes' => array(
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

        $data->attributes->domain = 'phptest'.time().'.com';

        $ns = new ForwardingCreate('array', $data);

        $this->assertTrue($ns instanceof ForwardingCreate);
    }
}
