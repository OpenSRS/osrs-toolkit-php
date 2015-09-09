<?php

use OpenSRS\domains\subreseller\SubresellerPay;
/**
 * @group subreseller
 * @group SubresellerPay
 */
class SubresellerPayTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subresPay';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * username: username for the sub-reseller
             *   that is receiving the funds
             * amount: amount you want to transfer to
             *   the sub-reseller account, must be a
             *   positive number
             */
            "username" => "",
            "amount" => "",
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->username = "subreseller" . time();
        $data->data->amount = "10.00";

        $ns = new SubresellerPay( 'array', $data );

        $this->assertTrue( $ns instanceof SubresellerPay );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     * @group missingusername
     */
    public function testInvalidSubmissionMissingUsername() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->username = "subreseller" . time();
        $data->data->amount = "10.00";

        $this->setExpectedExceptionRegExp(
            'OpenSRS\Exception',
            '/username.*not defined/'
            );



        // not sending username
        unset( $data->data->username );
        $ns = new SubresellerPay( 'array', $data );
     }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     * @group missingamount
     */
    public function testInvalidSubmissionMissingAmount() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->username = "subreseller" . time();
        $data->data->amount = "10.00";

        $this->setExpectedExceptionRegExp(
            'OpenSRS\Exception',
            '/amount.*not defined/'
            );



        // not sending amount
        unset( $data->data->amount );
        $ns = new SubresellerPay( 'array', $data );
     }
}
