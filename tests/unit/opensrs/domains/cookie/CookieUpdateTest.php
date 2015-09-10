<?php

use OpenSRS\domains\cookie\CookieUpdate;
/**
 * @group cookie
 * @group CookieUpdate
 */
class CookieUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'cookieUpdate';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * cookie: OpenSRS auth cookie (see CookieSet)
             * domain: relevant domain, required if
             *   'cookie' is not set
             * domain_new: new domain for the cookie
             * reg_username: registrant's username
             * reg_password: registrant's password
             */
            "cookie" => "",
            "domain" => "",
            "domain_new" => "",
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
    public function testValidSubmission()
    {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->domain_new = "phptest" . md5(time()) . ".com";
        $data->data->reg_username = "phptest";
        $data->data->reg_password = "password12345";

        $ns = new CookieUpdate( 'array', $data );

        $this->assertTrue( $ns instanceof CookieUpdate );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing cookie' => array('cookie'),
            'missing domain' => array('domain'),
            'missing domain_new' => array('domain_new'),
            'missing reg_password' => array('reg_password'),
            'missing reg_username' => array('reg_username'),
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

        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->domain_new = "phptest" . md5(time()) . ".com";
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

        $ns = new CookieUpdate( 'array', $data );
    }
}
