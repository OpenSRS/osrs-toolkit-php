<?php

use OpenSRS\domains\forwarding\ForwardingSet;
/**
 * @group forwarding
 * @group ForwardingSet
 */
class ForwardingSetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdSet';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: relevant domain, required
             *   only if cookie is not sent
             */
            "cookie" => "",
            "domain" => "",

            /**
             * Required
             *
             * subdomain: third level domain such as
             *   www or ftp, ie: if you specify www
             *   visitors to example.com are redirected
             *   to www.example.com. max 128 chars
             *   * note: although this parameter is required,
             *           its value can be null
             */
            "subdomain" => "",

            /**
             * Optional
             *
             * description: short description of
             *   your website, max 255 characters,
             *   only takes effect if masked=1
             * destination_url: full address of
             *   the website to forward to (complete
             *   domain or IP address), max 200 chars
             * enabled: determines whether domain
             *   forwarding is in effect
             *   0 = turn off forwarding
             *   1 = turn on forwarding
             * keywords: descriptive keywords that a
             *   visitor might use when searching for
             *   your website, comma separated
             * masked: determines the destination
             *   website address appears in the browser
             *   address field
             *   0 = display destination address
             *   1 = show original domain address
             * title: text that you want to appear in
             *   the browser title bar, max 255 chars,
             *   only takes effect if masked=1
             */
            "description" => "",
            "destination_url" => "",
            "enabled" => "",
            "keywords" => "",
            "masked" => "",
            "title" => ""
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

        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->subdomain = "null";

        $ns = new ForwardingSet( 'array', $data );

        $this->assertTrue( $ns instanceof ForwardingSet );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing bypass' => array('bypass'),
            'missing subdomain' => array('subdomain'),
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
        $data->data->bypass = $data->data->domain;
        $data->data->subdomain = "null";

        $this->setExpectedException( 'OpenSRS\Exception' );

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

        $ns = new ForwardingSet( 'array', $data );
     }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsCookieAndBypassSent() {
        $data = json_decode( json_encode($this->validSubmission) );

        // assign_ns request
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->bypass = $data->data->domain;
        $data->data->subdomain = "null";

        $this->setExpectedExceptionRegExp(
          'OpenSRS\Exception',
        "/.*cookie.*bypass.*cannot.*one.*call.*/"
          );

        $ns = new ForwardingSet( 'array', $data );
    }
}
