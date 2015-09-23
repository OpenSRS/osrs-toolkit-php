<?php

use opensrs\domains\transfer\TransferProcess;

/**
 * @group transfer
 * @group TransferProcess
 */
class TransferProcessTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferProcess';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * order_id: ID of the order to be
             *   resubmitted
             * reseller: reseller username
             */
            'order_id' => '',
            'reseller' => '',
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

        $data->attributes->order_id = time();
        $data->attributes->reseller = 'phptest'.time();

        $ns = new TransferProcess('array', $data);

        $this->assertTrue($ns instanceof TransferProcess);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing order_id' => array('order_id'),
            'missing reseller' => array('reseller'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->order_id = time();
        $data->attributes->reseller = 'phptest'.time();

        if (is_null($message)) {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$field.*not defined/"
              );
        } else {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$message/"
              );
        }

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new TransferProcess('array', $data);
    }
}
