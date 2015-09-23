<?php

use opensrs\domains\subuser\SubuserGet;

/**
 * @group subuser
 * @group SubuserGet
 */
class SubuserGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subuserGet';

    protected $validSubmission = array(
        'cookie' => '',

        'attributes' => array(
            /*
             * Required: 1 of 2
             *
             * cookie: domain auth cookie
             * domain: relevant domain, required
             *   only if cookie is not sent
             */
            'domain' => '',

            /*
             * Required
             *
             * username: sub-user username
             *   to get info for
             */
            'username' => '',
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

        $data->attributes->username = 'phptest'.time();

        $ns = new SubuserGet('array', $data);

        $this->assertTrue($ns instanceof SubuserGet);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing cookie' => array('cookie', null),
            'missing username' => array('username'),
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

        $ns = new SubuserGet('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionCookieAndBypassSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';

        $data->attributes->username = 'phptest'.time();

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            '/.*cookie.*domain.*cannot.*one.*call.*/'
            );

        $ns = new SubuserGet('array', $data);
    }
}
