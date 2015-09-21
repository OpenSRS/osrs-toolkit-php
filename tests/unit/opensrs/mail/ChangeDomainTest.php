<?php

use OpenSRS\mail\ChangeDomain;
/**
 * @group mail
 * @group MailChangeDomain
 */
class ChangeDomainTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'admin_username' => '',
            'admin_password' => '',
            'admin_domain' => '',
            'domain' => '',
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
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->data->admin_username = 'phptest' . time();
        $data->data->admin_password = 'password1234';
        $data->data->admin_domain = 'mail.phptest' . time() . '.com';
        $data->data->domain = 'new-' . $data->data->admin_domain;

        $ns = new ChangeDomain( 'array', $data );

        $this->assertTrue( $ns instanceof ChangeDomain );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing admin_username' => array('admin_username'),
            'missing admin_password' => array('admin_password'),
            'missing admin_domain' => array('admin_domain'),
            'missing domain' => array('domain'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmissionmail
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->data->admin_username = 'phptest' . time();
        $data->data->admin_password = 'password1234';
        $data->data->admin_domain = 'mail.phptest' . time() . '.com';
        $data->data->domain = 'new-' . $data->data->admin_domain;
        
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

        $ns = new ChangeDomain( 'array', $data );
    }
}
