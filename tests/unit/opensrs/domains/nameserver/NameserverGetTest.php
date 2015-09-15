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
        "cookie" => "",

        "attributes" => array(
            /**
             * Required
             *
             * bypass: relevant bypass, required
             *   only if cookie is not set
             * name: fully qualified domain name
             *   for the nameserver
             */
            "bypass" => "",
            "name" => "",
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
        $data->cookie = md5(time());
        $data->attributes->name = "ns1.phptest" . time() . ".com";

        $ns = new NameserverGet( 'array', $data );

        $this->assertTrue( $ns instanceof NameserverGet );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
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
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'attributes', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        // assign_ns request
        $data->cookie = md5(time());
        $data->attributes->name = "ns1.phptest" . time() . ".com";

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

        $ns = new NameserverGet( 'array', $data );
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
        $data->cookie = md5(time());
        $data->attributes->domain = "phptest" . time() . ".com";
        $data->attributes->name = "ns1.phptest" . time() . ".com";

        $this->setExpectedExceptionRegExp(
          'OpenSRS\Exception',
        "/.*cookie.*bypass.*cannot.*one.*call.*/"
          );

        $ns = new NameserverGet( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsNoCookieOrDomainSent() {
        $data = json_decode( json_encode($this->validSubmission) );

        // assign_ns request
        $data->attributes->name = "ns1.phptest" . time() . ".com";

        $this->setExpectedExceptionRegExp(
            'OpenSRS\Exception',
            "/(cookie|domain).*not.*defined/"
            );

        $ns = new NameserverGet( 'array', $data );
    }
}
