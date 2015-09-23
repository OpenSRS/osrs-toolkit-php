<?php

namespace opensrs\publishing;

/**
 * @group publishing
 * @group publishing\GenerateRedirectionCode
 */
class GenerateRedirectionCodeTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'domain' => '',
            'service_type' => '',
            'programming_language' => '',
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
        $data->attributes->service_type = 'phptest'.time();
        $data->attributes->programming_language = 'php';

        $ns = new GenerateRedirectionCode('array', $data);

        $this->assertTrue($ns instanceof GenerateRedirectionCode);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
            'missing service_type' => array('service_type'),
            'missing programming_language' => array('programming_language'),
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
        $data->attributes->service_type = 'phptest'.time();
        $data->attributes->programming_language = 'php';

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

        $ns = new GenerateRedirectionCode('array', $data);
    }
}
