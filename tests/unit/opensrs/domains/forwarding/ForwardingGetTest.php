<?php

use OpenSRS\domains\forwarding\ForwardingGet;
/**
 * @group forwarding
 * @group ForwardingGet
 */
class ForwardingGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdGet';

    protected $validSubmission = array(
        "data" => array(
            "func" => "fwdGet",

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

        $ns = new ForwardingGet( 'array', $data );

        $this->assertTrue( $ns instanceof ForwardingGet );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );

        // assign_ns request
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no domain sent
        unset( $data->data->domain );
        $ns = new ForwardingGet( 'array', $data );



        // setting cookie and bypass in the
        // same request
        $data->data->bypass = $data->data->cookie;
        $ns = new ForwardingGet( 'array', $data );
        // removing bypass
        unset( $data->data->bypass );



        // no cookie sent
        unset( $data->data->cookie );
        $ns = new ForwardingGet( 'array', $data );
     }
}
