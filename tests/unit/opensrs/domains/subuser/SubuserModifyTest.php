<?php

use OpenSRS\domains\subuser\SubuserModify;
/**
 * @group subuser
 * @group SubuserModify
 */
class SubuserModifyTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subuserModify';

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
             * sub_username: username for the sub-user
             * sub_permission: bit-mask indicating
             *   which portions of the domain information
             *   are changeable by the sub-user, bits
             *   are as follows:
             *     - 1 = Owner
             *     - 2 = Admin
             *     - 4 = Billing
             *     - 8 = Tech
             *     - 16 = Nameservers
             *     - 32 = Rsp_whois_info
             * sub_password: password for the sub-user
             * sub_id: the ID of the sub-user to
             *   modify
             */
            "username" => "",
            "sub_username" => "",
            "sub_permission" => "",
            "sub_password" => "",
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
        $data->data->sub_username = "phptestuser";
        $data->data->sub_permission = "2";
        $data->data->sub_password = "password1234";
        $data->data->sub_id = time();

        $ns = new SubuserModify( 'array', $data );

        $this->assertTrue( $ns instanceof SubuserModify );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing bypass' => array('bypass'),
            'missing username' => array('username'),
            'missing sub_username' => array('sub_username'),
            'missing sub_permission' => array('sub_permission'),
            'missing sub_password' => array('sub_password'),
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

        $data->data->username = "phptest" . time() . ".com";
        $data->data->sub_username = "phptestuser" . time();
        $data->data->sub_permission = "2";
        $data->data->sub_password = "password1234";
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

        $ns = new SubuserModify( 'array', $data );
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

        $data->data->username = "phptest" . time() . ".com";
        $data->data->sub_username = "phptestuser" . time();
        $data->data->sub_permission = "2";
        $data->data->sub_password = "password1234";
        $data->data->sub_id = time();

        $this->setExpectedExceptionRegExp(
            'OpenSRS\Exception',
            "/.*cookie.*bypass.*cannot.*one.*call.*/"
            );

        $ns = new SubuserModify( 'array', $data );
    }
}
