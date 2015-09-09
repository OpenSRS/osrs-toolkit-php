<?php

use OpenSRS\domains\transfer\TransferProcess;
/**
 * @group transfer
 * @group TransferProcess
 */
class TransferProcessTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferProcess';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * order_id: ID of the order to be
             *   resubmitted
             * reserller: reseller username
             */
            "order_id" => "",
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

        $data->data->order_id = time();
        $data->data->reseller = "phptest" . time();

        $ns = new TransferProcess( 'array', $data );

        $this->assertTrue( $ns instanceof TransferProcess );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing order_id' => array('order_id'),
            'missing reseller' => array('reseller'),
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

        $data->data->order_id = time();
        $data->data->reseller = "phptest" . time();

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

        $ns = new TransferProcess( 'array', $data );
    }
}
