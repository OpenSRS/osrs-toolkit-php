<?php

use opensrs\domains\transfer\TransferCheck;

/**
 * @group transfer
 * @group TransferCheck
 */
class TransferCheckTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferCheck';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain: fully qualified domain
             *   name in the transfer order
             */
            'domain' => '',

            /*
             * Optional
             *
             * get_request_address: flag to
             *   request the registrant's
             *   contact email. useful if you
             *   want to make sure your client
             *   can receive mail at that address
             *   to acknowledge the tranfer
             *     allowed values: 0 or 1
             * check_status: flag to request
             *   status of a transfer request
             *     allowed values: 0 or 1
             */
            'get_request_address' => '',
            'check_status' => '',
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

        $data->attributes->check_status = '0';
        $data->attributes->get_request_address = '0';

        $ns = new TransferCheck('array', $data);

        $this->assertTrue($ns instanceof TransferCheck);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
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

        $data->attributes->domain = 'phptest'.time().'.com';

        $data->attributes->check_status = '0';
        $data->attributes->get_request_address = '0';

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

        $ns = new TransferCheck('array', $data);
    }
}
