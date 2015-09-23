<?php

use opensrs\domains\cookie\CookieUpdate;

/**
 * @group cookie
 * @group CookieUpdate
 */
class CookieUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'cookieUpdate';

    protected $validSubmission = array(
        /*
         * Required
         *
         * cookie: OpenSRS auth cookie (see CookieSet)
         */
        'cookie' => '',

        'attributes' => array(
            /*
             * Required
             *
             * domain: relevant domain, required if
             *   'cookie' is not set
             * domain_new: new domain for the cookie
             * reg_username: registrant's username
             * reg_password: registrant's password
             */
            'domain' => '',
            'domain_new' => '',
            'reg_username' => 'phptest',
            'reg_password' => 'password12345',
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
        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->domain_new = 'phptest'.md5(time()).'.com';
        $data->attributes->reg_username = 'phptest';
        $data->attributes->reg_password = 'password12345';

        $ns = new CookieUpdate('array', $data);

        $this->assertTrue($ns instanceof CookieUpdate);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing cookie' => array('cookie', null),
            'missing domain' => array('domain'),
            'missing domain_new' => array('domain_new'),
            'missing reg_password' => array('reg_password'),
            'missing reg_username' => array('reg_username'),
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

        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->domain_new = 'phptest'.md5(time()).'.com';
        $data->attributes->reg_username = 'phptest';
        $data->attributes->reg_password = 'password12345';

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

        $ns = new CookieUpdate('array', $data);
    }
}
