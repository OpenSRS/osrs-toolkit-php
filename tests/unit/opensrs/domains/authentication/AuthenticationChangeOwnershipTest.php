<?php

use opensrs\domains\authentication\AuthenticationChangeOwnership;

/**
 * @group authentication
 * @group AuthenticationChangeOwnership
 */
class AuthenticationChangeOwnershipTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'authChangeOwnership';

    protected $validSubmission = array(
        'cookie' => '',

        'attributes' => array(
            /*
             * Required: one of 'cookie' (above) or 'domain'
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
             */
            'username' => '',
            'password' => '',

            /*
             * Optional
             * If not submitted, only the domain(s)
             * identified by 'cookie' are moved
             * 
             * 0 = do not move all domains to new profile
             * 1 = move all domains to the new profile
             */
            'move_all' => '',

            /*
             * Optional
             * If included, user can change domain from
             * one profile to another (existing) profile.
             * If not included, username/password provided
             * are used to create a new profile
             */
            'reg_domain' => '',
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

        $ns = new AuthenticationChangeOwnership('array', $data);

        $this->assertTrue($ns instanceof AuthenticationChangeOwnership);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing cookie' => array('cookie', null),
            'missing username' => array('username'),
            'missing password' => array('password'),
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
        $data->attributes->username = 'phptest'.time();
        $data->attributes->password = 'password1234';

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

        $ns = new AuthenticationChangeOwnership('array', $data);
    }
}
