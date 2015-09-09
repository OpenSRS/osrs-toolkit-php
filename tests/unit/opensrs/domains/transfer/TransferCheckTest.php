<?php

use OpenSRS\domains\transfer\TransferCheck;
/**
 * @group transfer
 * @group TransferCheck
 */
class TransferCheckTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferCheck';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * domain: fully qualified domain
             *   name in the transfer order
             */
            "domain" => "",

            /**
             * Optional
             *
             * get_request_address: flag to
             *   request the registrant's
             *   contact email. useful if you
             *   want to make sure your client
             *   can receive mail at that address
             *   to acknowledge the tranfer
             *     allowed values: 0 or 1
             * check_status: flag to request
             *   status of a transfer request
             *     allowed values: 0 or 1
             */
            "reseller" => "",
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

        $data->data->domain = "phptest" . time() . ".com";

        $data->data->check_status = "0";
        $data->data->get_request_address = "0";

        $ns = new TransferCheck( 'array', $data );

        $this->assertTrue( $ns instanceof TransferCheck );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";

        $data->data->check_status = "0";
        $data->data->get_request_address = "0";

        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new TransferCheck( 'array', $data );
    }
}
