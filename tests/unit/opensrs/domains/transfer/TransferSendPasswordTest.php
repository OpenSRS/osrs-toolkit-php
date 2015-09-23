<?php

use opensrs\domains\transfer\TransferSendPassword;

/**
 * @group transfer
 * @group TransferSendPassword
 */
class TransferSendPasswordTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferSendPassword';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain_name: domain name for which
             *   to initialize the password
             */
            'domain_name' => '',
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

        $data->attributes->domain_name = 'phptest'.time().'.com';

        $ns = new TransferSendPassword('array', $data);

        $this->assertTrue($ns instanceof TransferSendPassword);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain_name' => array('domain_name'),
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

        $data->attributes->domain_name = 'phptest'.time().'.com';

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

        $ns = new TransferSendPassword('array', $data);
    }
}
