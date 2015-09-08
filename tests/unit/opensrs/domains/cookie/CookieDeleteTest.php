<?php

use OpenSRS\domains\cookie\CookieDelete;

/**
 * @group cookie
 * @group CookieDelete
 */
class CookieDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $fund = "cookieDelete";

    protected $validSubmission = array(
        "data" => array(
            "func" => "cookieDelete",

            /**
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: relevant domain, required
             *   only if cookie is not sent
             */
            "cookie" => "",
            "domain" => "",
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

        $ns = new CookieDelete( 'array', $data );

        $this->assertTrue( $ns instanceof CookieDelete );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );
        $this->setExpectedException( 'OpenSRS\Exception' );


        // no cookie sent
        unset( $data->data->cookie );
        $ns = new CookieDelete( 'array', $data );
    }
}
