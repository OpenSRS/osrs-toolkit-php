<?php

use OpenSRS\domains\nameserver\NameserverCreate;
/**
 * @group nameserver
 * @group NameserverCreate
 */
class NameserverCreateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'nsCreate';
    
    protected $validSubmission = array(
        "data" => array(
            "func" => "nsCreate",

            /**
             * Required
             *
             * domain: relevant domain, required
             *   only if cookie is not set
             * ipaddress: IPv4 address of the
             *   nameserver. always required for
             *   .DE, otherwise required only if
             *   ipv6 is not submitted
             * ipv6: ipv6 address of the nameserver
             *   * not supported for .cn domains
             * name: fully qualified domain name
             *   for the nameserver
             */
            "cookie" => "",
            "domain" => "",
            "ipaddress" => "",
            "ipv6" => "",
            "name" => "",

            /**
             * Optional
             *
             * add_to_all_registry: adds nameserver
             *   to other registries so it can be used
             *   on other TLDs
             */
            "add_to_all_registry" => "",
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

        // generate a random IPv4
        $data->data->ipaddress = long2ip(mt_rand());

        // generate a random (fake) IPv6
        $data->data->ipv6 = implode(':', str_split(sha1(dechex(mt_rand(0, 2147483647))), 4));
        $data->data->name = "ns1." . $data->data->domain;

        $ns = new NameserverCreate( 'array', $data );
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

        // generate a random IPv4
        $data->data->ipaddress = long2ip(mt_rand());

        // generate a random (fake) IPv6
        $data->data->ipv6 = implode(':', str_split(sha1(dechex(mt_rand(0, 2147483647))), 4));
        $data->data->name = "ns1." . $data->data->domain;

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no ipaddress sent
        unset( $data->data->ipaddress );
        $ns = new NameserverCreate( 'array', $data );



        // no name sent
        unset( $data->data->name );
        $ns = new NameserverCreate( 'array', $data );



        // setting cookie and bypass in the
        // same request
        $data->data->bypass = $data->data->cookie;
        $ns = new NameserverCreate( 'array', $data );
        // removing bypass
        unset( $data->data->bypass );



        // no cookie sent
        unset( $data->data->cookie );
        $ns = new NameserverCreate( 'array', $data );
    }
}
