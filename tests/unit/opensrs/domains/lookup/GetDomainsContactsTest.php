<?php

use opensrs\domains\lookup\GetDomainsContacts;

/**
 * @group lookup
 * @group GetDomainsContacts
 */
class GetDomainsContactsTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'lookupGetDomainsContacts';

    protected $validSubmission = array(
        'attributes' => array(
            'domain_list' => '',
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

        $data->attributes->domain_list = 'phptest'.time().'.com';

        $ns = new GetDomainsContacts('array', $data);

        $this->assertTrue($ns instanceof GetDomainsContacts);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain_list' => array('domain_list'),
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

        $data->attributes->domain_list = 'phptest'.time().'.com';

        $this->setExpectedException('opensrs\Exception');

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

        $ns = new GetDomainsContacts('array', $data);
    }
}
