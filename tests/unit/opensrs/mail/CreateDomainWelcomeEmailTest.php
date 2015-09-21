<?php

namespace OpenSRS\mail;

use OpenSRS\mail\CreateDomainWelcomeEmail;
/**
 * @group mail
 * @group MailCreateDomainWelcomeEmail
 */
class CreateDomainWelcomeEmailTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'admin_username' => '',
            'admin_password' => '',
            'admin_domain' => '',
            'domain' => '',
            'welcome_text' => '',
            'welcome_subject' => '',
            'from_name' => '',
            'from_address' => '',
            'charset' => '',
            'mime_type' => '',
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
        $data->data->welcome_text = "Welcome";
        $data->data->welcome_subject = "Welcome!";
        $data->data->from_name = "Tikloot Php";
        $data->data->from_address = "phptoolkit@tucows.com";
        $data->data->charset = "UTF-8";
        $data->data->mime_type = "text/plain";

        $ns = new CreateDomainWelcomeEmail( 'array', $data );

        $this->assertTrue( $ns instanceof CreateDomainWelcomeEmail );
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
            'missing welcome_text' => array('welcome_text'),
            'missing welcome_subject' => array('welcome_subject'),
            'missing from_name' => array('from_name'),
            'missing from_address' => array('from_address'),
            'missing charset' => array('charset'),
            'missing mime_type' => array('mime_type'),
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
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->data->admin_username = 'phptest' . time();
        $data->data->admin_password = 'password1234';
        $data->data->admin_domain = 'mail.phptest' . time() . '.com';
        $data->data->domain = 'new-' . $data->data->admin_domain;
        $data->data->welcome_text = "Welcome";
        $data->data->welcome_subject = "Welcome!";
        $data->data->from_name = "Tikloot Php";
        $data->data->from_address = "phptoolkit@tucows.com";
        $data->data->charset = "UTF-8";
        $data->data->mime_type = "text/plain";
        
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

        $ns = new CreateDomainWelcomeEmail( 'array', $data );
    }
}
