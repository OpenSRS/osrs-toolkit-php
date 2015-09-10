<?php

use OpenSRS\domains\authentication\AuthenticationSendAuthCode;

/**
 * @group authentication
 * @group AuthenticationSendAuthCode
 */
class AuthenticationSendAuthCodeTest extends PHPUnit_Framework_TestCase
{
    protected $fund = "authSendAuthcode";

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * The EPP domain name for which the
             * Authcode is to be sent
             */
            "domain_name" => ""
            )
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
        
        $data->data->domain_name = "phptest" . time() . ".com";

        $ns = new AuthenticationSendAuthCode( 'array', $data );

        $this->assertTrue( $ns instanceof AuthenticationSendAuthCode );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain_name' => array('domain_name'),
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

        $data->data->domain_name = "phptest" . time() . ".com";

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

        $ns = new AuthenticationSendAuthCode( 'array', $data );
    }
}
