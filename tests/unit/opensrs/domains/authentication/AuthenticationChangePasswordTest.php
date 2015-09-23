<?php

use opensrs\domains\authentication\AuthenticationChangePassword;

/**
 * @group authentication
 * @group AuthenticationChangePassword
 */
class AuthenticationChangePasswordTest extends PHPUnit_Framework_TestCase
{
    protected $fund = 'authChangePassword';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required: one of 'cookie' or 'domain'
             *
             * cookie: authentication cookie
             *   * see domains\cookie\CookieSet
             * domain: the relevant domain (only
             *   required if 'cookie' is not sent)
             */
            'cookie' => '',
            'domain' => '',

            /*
             * Required
             *
             * The new password for the registrant
             */
            'reg_password' => '',
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

        $data->attributes->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->reg_password = password_hash(md5(time()), PASSWORD_BCRYPT);

        $ns = new AuthenticationChangePassword('array', $data);

        $this->assertTrue($ns instanceof AuthenticationChangePassword);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing reg_password' => array('reg_password'),
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

        $data->attributes->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->reg_password = password_hash(md5(time()), PASSWORD_BCRYPT);

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

        $ns = new AuthenticationChangePassword('array', $data);
    }
}
