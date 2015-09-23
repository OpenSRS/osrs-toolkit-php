<?php

use opensrs\domains\subreseller\SubresellerPay;

/**
 * @group subreseller
 * @group SubresellerPay
 */
class SubresellerPayTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subresPay';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * username: username for the sub-reseller
             *   that is receiving the funds
             * amount: amount you want to transfer to
             *   the sub-reseller account, must be a
             *   positive number
             */
            'username' => '',
            'amount' => '',
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

        $data->attributes->username = 'subreseller'.time();
        $data->attributes->amount = '10.00';

        $ns = new SubresellerPay('array', $data);

        $this->assertTrue($ns instanceof SubresellerPay);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing username' => array('username'),
            'missing amount' => array('amount'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes')
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->username = 'subreseller'.time();
        $data->attributes->amount = '10.00';

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            "/$field.*not defined/"
            );

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new SubresellerPay('array', $data);
    }
}
