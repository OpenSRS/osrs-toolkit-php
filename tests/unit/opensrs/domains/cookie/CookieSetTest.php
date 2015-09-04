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
            "func" => "cookieSet",

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
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->reg_username = "phptest";
        $data->data->reg_password = "password12345";

        $ns = new CookieSet( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->reg_username = "phptest";
        $data->data->reg_password = "password12345";

        $this->setExpectedException( 'OpenSRS\Exception' );


        // no domain sent
        unset( $data->data->domain );
        $ns = new CookieSet( 'array', $data );


        // no reg_password sent
        unset( $data->data->reg_password );
        $ns = new CookieSet( 'array', $data );


        // no reg_username sent
        unset( $data->data->reg_username );
        $ns = new CookieSet( 'array', $data );
    }
}
