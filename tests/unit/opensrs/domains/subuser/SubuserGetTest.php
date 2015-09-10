<?php

use OpenSRS\domains\subuser\SubuserGet;
/**
 * @group subuser
 * @group SubuserGet
 */
class SubuserGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subuserGet';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required: 1 of 2
             *
             * cookie: domain auth cookie
             * bypass: relevant domain, required
             *   only if cookie is not sent
             */
            "cookie" => "",
            "bypass" => "",

            /**
             * Required
             *
             * username: sub-user username
             *   to get info for
             */
            "username" => "",
            ),
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

        $data->data->bypass = "phptest" . time() . ".com";

        $data->data->username = "phptest" . time();

        $ns = new SubuserGet( 'array', $data );

        $this->assertTrue( $ns instanceof SubuserGet );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing bypass' => array('bypass'),
            'missing username' => array('username'),
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

        $data->data->bypass = "phptest" . time() . ".com";

        $data->data->username = "phptest" . time();

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

        $ns = new SubuserGet( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionCookieAndBypassSent() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->cookie = md5(time());
        $data->data->bypass = "phptest" . time() . ".com";

        $data->data->username = "phptest" . time();

        $this->setExpectedExceptionRegExp(
            'OpenSRS\Exception',
            "/.*cookie.*bypass.*cannot.*one.*call.*/"
            );

        $ns = new SubuserGet( 'array', $data );
    }
}
