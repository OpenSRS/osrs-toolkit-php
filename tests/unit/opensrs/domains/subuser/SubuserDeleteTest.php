<?php

use OpenSRS\domains\subuser\SubuserDelete;
/**
 * @group subuser
 * @group SubuserDelete
 */
class SubuserDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subuserDelete';

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
             * username: parent user's username
             * sub_id: The ID of the sub-user 
             *   to be deleted.
             */
            "username" => "",
            "sub_id" => "",
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
        $data->data->sub_id = time();

        $ns = new SubuserDelete( 'array', $data );

        $this->assertTrue( $ns instanceof SubuserDelete );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing bypass' => array('bypass'),
            'missing username' => array('username'),
            'missing sub_id' => array('sub_id'),
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
        $data->data->sub_id = time();

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

        $ns = new SubuserDelete( 'array', $data );
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
        $data->data->sub_id = time();

        $this->setExpectedExceptionRegExp(
            'OpenSRS\Exception',
            "/.*cookie.*bypass.*cannot.*one.*call.*/"
            );

        $ns = new SubuserDelete( 'array', $data );
    }
}
