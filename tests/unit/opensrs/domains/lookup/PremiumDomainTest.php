<?php

use opensrs\domains\lookup\PremiumDomain;

/**
 * @group lookup
 * @group PremiumDomain
 */
class PremiumDomainTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'lookupPremiumDomain';

    protected $validSubmission = array(
        'attributes' => array(
            'searchstring' => '',
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

        $data->attributes->searchstring = 'phptest'.time().'.com';

        $ns = new PremiumDomain('array', $data);

        $this->assertTrue($ns instanceof PremiumDomain);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing searchstring' => array('searchstring'),
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

        $data->attributes->searchstring = 'phptest'.time().'.com';

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

        $ns = new PremiumDomain('array', $data);
    }
}
