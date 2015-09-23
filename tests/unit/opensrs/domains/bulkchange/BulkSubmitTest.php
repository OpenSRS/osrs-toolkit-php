<?php

use opensrs\domains\bulkchange\BulkSubmit;

/**
 * @group bulkchange
 * @group BulkSubmit
 */
class BulkSubmitTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'change_type' => '',
            'change_items' => '',
            'op_type' => '',
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

        $data->attributes->change_type = 'dns_zone';
        $data->attributes->change_items = 'ns1.phptest.com,ns2.phptest.com';
        $data->attributes->op_type = 'test_op_type';
        $data->attributes->contact_email = 'phptoolkit@tucows.com';
        $data->attributes->apply_to_locked_domains = 'N';

        $ns = new BulkSubmit('array', $data);

        $this->assertTrue($ns instanceof BulkSubmit);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing op_type' => array('op_type'),
            'missing change_type' => array('change_type'),
            'missing change_items' => array('change_items'),
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

        $data->attributes->change_type = 'dns_zone';
        $data->attributes->change_items = 'ns1.phptest.com,ns2.phptest.com';
        $data->attributes->op_type = 'test_op_type';
        $data->attributes->contact_email = 'phptoolkit@tucows.com';
        $data->attributes->apply_to_locked_domains = 'N';

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

        $ns = new BulkSubmit('array', $data);
    }
}
