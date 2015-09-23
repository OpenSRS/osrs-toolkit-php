<?php

use opensrs\domains\cookie\CookieDelete;

/**
 * @group cookie
 * @group CookieDelete
 */
class CookieDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $fund = 'cookieDelete';

    protected $validSubmission = array(
        /*
         * Required
         *
         * cookie: cookie to be deleted
         */
        'cookie' => '',

        'attributes' => array(
            'cookie' => '',
            'domain' => '',
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
        $data->attributes->cookie = $data->cookie;
        $data->attributes->domain = 'phptest'.time().'.com';

        $ns = new CookieDelete('array', $data);

        $this->assertTrue($ns instanceof CookieDelete);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing root cookie' => array('cookie', null),
            'missing cookie' => array('cookie'),
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

        $data->cookie = md5(time());
        $data->attributes->cookie = $data->cookie;
        $data->attributes->domain = 'phptest'.time().'.com';

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

        $ns = new CookieDelete('array', $data);
    }
}
