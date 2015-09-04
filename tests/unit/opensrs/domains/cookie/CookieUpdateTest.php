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
            "func" => "cookieUpdate",

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
    public function testValidateMissingDomainList()
    {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->domain_new = "phptest" . md5(time()) . ".com";
        $data->data->reg_username = "phptest";
        $data->data->reg_password = "password12345";

        $ns = new CookieUpdate( 'array', $data );
    }

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
        $data->data->domain_new = "phptest" . md5(time()) . ".com";
        $data->data->reg_username = "phptest";
        $data->data->reg_password = "password12345";
        
        $this->setExpectedException( 'OpenSRS\Exception' );


        // no cookie sent
        unset( $data->data->cookie );
        $ns = new CookieUpdate( 'array', $data );


        // no domain_new sent
        unset( $data->data->domain_new );
        $ns = new CookieUpdate( 'array', $data );


        // no domain sent
        unset( $data->data->domain );
        $ns = new CookieUpdate( 'array', $data );


        // no reg_password sent
        unset( $data->data->reg_password );
        $ns = new CookieUpdate( 'array', $data );


        // no reg_username sent
        unset( $data->data->reg_username );
        $ns = new CookieUpdate( 'array', $data );
    }
}
