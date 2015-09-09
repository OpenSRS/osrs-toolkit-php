<?php

use OpenSRS\domains\nameserver\NameserverModify;
/**
 * @group nameserver
 * @group NameserverModify
 */
class NameserverModifyTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'nsDelete';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * bypass: relevant domain, required
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
            "bypass" => "",
            "ipaddress" => "",
            "ipv6" => "",
            "name" => "",

            /**
             * Optional
             *
             * new_name: only required if you
             *   are changing the name
             */
            "new_name" => ""
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

        // assign_ns request
        $data->data->bypass = "phptest" . time() . ".com";

        // generate a random IPv4
        $data->data->ipaddress = long2ip(mt_rand());

        // generate a random (fake) IPv6
        $data->data->ipv6 = implode(':', str_split(sha1(dechex(mt_rand(0, 2147483647))), 4));
        $data->data->name = "ns1." . $data->data->bypass;
        $data->data->new_name = "new_ns1." . $data->data->bypass;

        $ns = new NameserverModify( 'array', $data );

        $this->assertTrue( $ns instanceof NameserverModify );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing bypass' => array('bypass'),
            'missing ipaddress' => array('ipaddress'),
            'missing name' => array('name'),
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

        // assign_ns request
        $data->data->bypass = "phptest" . time() . ".com";

        // generate a random IPv4
        $data->data->ipaddress = long2ip(mt_rand());

        // generate a random (fake) IPv6
        $data->data->ipv6 = implode(':', str_split(sha1(dechex(mt_rand(0, 2147483647))), 4));
        $data->data->name = "ns1." . $data->data->bypass;
        $data->data->new_name = "new_ns1." . $data->data->bypass;

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

        $ns = new NameserverModify( 'array', $data );
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
        $data->data->bypass = "phptest" . time() . ".com";

        // generate a random IPv4
        $data->data->ipaddress = long2ip(mt_rand());

        // generate a random (fake) IPv6
        $data->data->ipv6 = implode(':', str_split(sha1(dechex(mt_rand(0, 2147483647))), 4));
        $data->data->name = "ns1." . $data->data->bypass;
        $data->data->new_name = "new_ns1." . $data->data->bypass;

        $this->setExpectedExceptionRegExp(
          'OpenSRS\Exception',
        "/.*cookie.*bypass.*cannot.*one.*call.*/"
          );

        $ns = new NameserverModify( 'array', $data );
    }
}
