<?php

use opensrs\domains\provisioning\ProvisioningProcessPending;

/**
 * @group provisioning
 * @group ProvisioningProcessPending
 */
class ProvisioningProcessPendingTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provProcessPending';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * order_id: id of order to be
             *   processed
             */
            'order_id' => '',
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

        // sending request with order_id only
        $data->attributes->order_id = time();

        $ns = new ProvisioningProcessPending('array', $data);

        $this->assertTrue($ns instanceof ProvisioningProcessPending);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing order_id' => array('order_id'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes')
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->order_id = time();

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            "/$field.*not defined/"
            );

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new ProvisioningProcessPending('array', $data);
    }
}
