<?php

use opensrs\domains\subuser\SubuserDelete;

/**
 * @group subuser
 * @group SubuserDelete
 */
class SubuserDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subuserDelete';

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
             * username: parent user's username
             * sub_id: The ID of the sub-user 
             *   to be deleted.
             */
            'username' => '',
            'sub_id' => '',
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

        $data->attributes->username = 'phptest'.time();
        $data->attributes->sub_id = time();

        $ns = new SubuserDelete('array', $data);

        $this->assertTrue($ns instanceof SubuserDelete);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing cookie' => array('cookie', null),
            'missing username' => array('username'),
            'missing sub_id' => array('sub_id'),
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
        $data->attributes->sub_id = time();

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

        $ns = new SubuserDelete('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionCookieAndDomainSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';

        $data->attributes->username = 'phptest'.time();
        $data->attributes->sub_id = time();

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            '/.*cookie.*domain.*cannot.*one.*call.*/'
            );

        $ns = new SubuserDelete('array', $data);
    }
}
