<?php

use OpenSRS\domains\cookie\CookieSet;
/**
 * @group cookie
 * @group CookieSet
 */
class CookieSetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'cookieSet';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * domain: relevant domain, multilingual
             *   domains must be race-encoded
             * reg_username: registrant's username
             * reg_password: registrant's password
             */
            "domain" => "",
            "reg_username" => "phptest",
            "reg_password" => "password12345",
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

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->reg_username = "phptest";
        $data->data->reg_password = "password12345";

        $ns = new CookieSet( 'array', $data );

        $this->assertTrue( $ns instanceof CookieSet );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing reg_username' => array('reg_username'),
            'missing reg_password' => array('reg_password'),
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
        $data->data->reg_username = "phptest";
        $data->data->reg_password = "password12345";

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

        $ns = new CookieSet( 'array', $data );
    }
}
