<?php

use opensrs\domains\authentication\AuthenticationSendAuthCode;

/**
 * @group authentication
 * @group AuthenticationSendAuthCode
 */
class AuthenticationSendAuthCodeTest extends PHPUnit_Framework_TestCase
{
    protected $fund = 'authSendAuthcode';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * The EPP domain name for which the
             * Authcode is to be sent
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

        $ns = new AuthenticationSendAuthCode('array', $data);

        $this->assertTrue($ns instanceof AuthenticationSendAuthCode);
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

        $ns = new AuthenticationSendAuthCode('array', $data);
    }
}
