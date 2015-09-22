<?php

namespace OpenSRS\mail;

use OpenSRS\mail\GetCompanyDomains;
/**
 * @group mail
 * @group MailGetCompanyDomains
 */
class GetCompanyDomainsTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'admin_username' => '',
            'admin_password' => '',
            'admin_domain' => '',
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

        $data->attributes->admin_username = 'phptest' . time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest' . time() . '.com';

        $ns = new GetCompanyDomains( 'array', $data );

        $this->assertTrue( $ns instanceof GetCompanyDomains );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing admin_username' => array('admin_username'),
            'missing admin_password' => array('admin_password'),
            'missing admin_domain' => array('admin_domain'),
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
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->attributes->admin_username = 'phptest' . time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest' . time() . '.com';
        
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

        $ns = new GetCompanyDomains( 'array', $data );
    }
}
