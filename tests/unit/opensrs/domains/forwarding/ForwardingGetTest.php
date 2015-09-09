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
            /**
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * bypass: relevant domain, required
             *   only if cookie is not sent
             */
            "cookie" => "",
            "bypass" => "",

            /**
             * Required
             *
             * domain: relevant domain
             */
            "domain" => "",
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

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->bypass = $data->data->domain;

        $ns = new ForwardingGet( 'array', $data );

        $this->assertTrue( $ns instanceof ForwardingGet );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing bypass' => array('bypass'),
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
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->bypass = $data->data->domain;

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

        $ns = new ForwardingGet( 'array', $data );
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

        $this->setExpectedExceptionRegExp(
          'OpenSRS\Exception',
        "/.*cookie.*bypass.*cannot.*one.*call.*/"
          );

        $ns = new ForwardingGet( 'array', $data );
    }
}
