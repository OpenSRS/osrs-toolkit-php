<?php

use OpenSRS\domains\nameserver\NameserverGet;
/**
 * @group nameserver
 * @group NameserverGet
 */
class NameserverGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'nsGet';

    protected $validSubmission = array(
        "data" => array(
            "func" => "nsGet",

            /**
             * Required
             *
             * domain: relevant domain, required
             *   only if cookie is not set
             * name: fully qualified domain name
             *   for the nameserver
             */
            "cookie" => "",
            "domain" => "",
            "name" => "",
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

        // assign_ns request
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->name = "ns1." . $data->data->domain;

        $ns = new NameserverGet( 'array', $data );

        $this->assertTrue( $ns instanceof NameserverGet );
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
        $data->data->name = "ns1." . $data->data->domain;

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no name sent
        unset( $data->data->name );
        $ns = new NameserverGet( 'array', $data );



        // setting cookie and bypass in the
        // same request
        $data->data->bypass = $data->data->cookie;
        $ns = new NameserverGet( 'array', $data );
        // removing bypass
        unset( $data->data->bypass );



        // no cookie sent
        unset( $data->data->cookie );
        $ns = new NameserverGet( 'array', $data );
    }
}
