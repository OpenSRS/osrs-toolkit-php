<?php

use opensrs\domains\transfer\TransferRsp2Rsp;

/**
 * @group transfer
 * @group TransferRsp2Rsp
 */
class TransferRsp2RspTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferRsp2Rsp';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain: fully qualified domain
             *   name in the transfer order
             * grsp: username of gaining reseller
             */
            'domain' => '',
            'grsp' => '',

            /*
             * Optional
             *
             * username: registrant username,
             *   if specified will be used for
             *   the new registration, otherwise
             *   original username will be used
             * password: registrant password,
             *   if specified will be used for
             *   the new registration, otherwise
             *   original password will be used
             */
            'username' => '',
            'password' => '',
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

        $data->attributes->grsp = 'phptest'.time();

        $ns = new TransferRsp2Rsp('array', $data);

        $this->assertTrue($ns instanceof TransferRsp2Rsp);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
            'missing domain' => array('grsp'),
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

        $data->attributes->grsp = 'phptest'.time();

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

        $ns = new TransferRsp2Rsp('array', $data);
    }
}
