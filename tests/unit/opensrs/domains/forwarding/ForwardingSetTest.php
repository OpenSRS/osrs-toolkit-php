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
            "func" => "fwdSet",

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
             * Array of forwarding attributes
             * and values
             *
             * Required
             *
             * subdomain: third level domain such as
             *   www or ftp, ie: if you specify www
             *   visitors to example.com are redirected
             *   to www.example.com. max 128 chars
             *   * note: although this parameter is required,
             *           its value can be null
             */
            "forwarding" => "",

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
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->subdomain = "null";

        $ns = new ForwardingSet( 'array', $data );
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
        $data->data->subdomain = "null";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no subdomain sent
        unset( $data->data->subdomain );
        $ns = new ForwardingSet( 'array', $data );



        // no domain sent
        unset( $data->data->domain );
        $ns = new ForwardingSet( 'array', $data );



        // setting cookie and bypass in the
        // same request
        $data->data->bypass = $data->data->cookie;
        $ns = new ForwardingSet( 'array', $data );
        // removing bypass
        unset( $data->data->bypass );



        // no cookie sent
        unset( $data->data->cookie );
        $ns = new ForwardingSet( 'array', $data );
     }
}
