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
            "func" => "authSendAuthcode",

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
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->domain_name = "phptest" . time() . ".com";

        $ns = new AuthenticationSendAuthCode( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );
        $this->setExpectedException( 'OpenSRS\Exception' );


        // no domain_name sent
        unset( $data->data->domain_name );
        $ns = new AuthenticationSendAuthCode( 'array', $data );
    }
}
