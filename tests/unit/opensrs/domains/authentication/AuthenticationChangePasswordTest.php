<?php

use OpenSRS\domains\authentication\AuthenticationChangePassword;

/**
 * @group authentication
 * @group AuthenticationChangePassword
 */
class AuthenticationChangePasswordTest extends PHPUnit_Framework_TestCase
{
    protected $fund = "authChangePassword";

    protected $validSubmission = array(
        "data" => array(
            "func" => "authChangePassword",

            /**
             * Required: one of 'cookie' or 'domain'
             *
             * cookie: authentication cookie
             *   * see domains\cookie\CookieSet
             * domain: the relevant domain (only
             *   required if 'cookie' is not sent)
             */
            "cookie" => "",
            "domain" => "",

            /**
             * Required
             *
             * The new password for the registrant
             */
            "reg_password" => ""
            )
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";

        $ns = new AuthenticationChangePassword( 'array', $data );

        $this->assertTrue( $ns instanceof AuthenticationChangePassword );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        
        $this->setExpectedException( 'OpenSRS\Exception' );


        // no reg_password sent
        unset( $data->data->reg_password );
        $ns = new AuthenticationChangePassword( 'array', $data );
    }
}
