<?php

use OpenSRS\domains\personalnames\PersonalNamesSURegister;
/**
 * @group personalnames
 * @group PersonalNamesSURegister
 */
class PersonalNamesSURegisterSuggestTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persSUregister';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * domain: domain name to register
             * forward_email: address to which
             *   email is forwarded to
             * mailbox_type: 'MAILBOX' or 'WEBMAIL_ONLY'
             *   (no IMAP/POP/SMTP)
             * password: registrant's initial email
             *   password
             */
            "domain" => "",
            "forward_email" => "",
            "mailbox_type" => "",
            "password" => "",

            /**
             * Optional
             *
             * Values used for DNS record associated
             * with the domain along with its value
             *
             * content: IP or FQDN. when specifying
             *    a domain name for CNAME, put a dot
             *    after the TLD
             * name: unqualified name of the DNS
             *    record. specify @ to indicate zone
             *    rather than another record
             * type: type of DNS record, A or CNAME
             */
            "content" => "",
            "name" => "",
            "type" => ""
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
        $data->data->mailbox_type = "MAILBOX";
        $data->data->password = "password12345";


        $ns = new PersonalNamesSURegister( 'array', $data );

        $this->assertTrue( $ns instanceof PersonalNamesSURegister );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing mailbox_type' => array('mailbox_type'),
            'missing password' => array('password'),
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

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->mailbox_type = "MAILBOX";
        $data->data->password = "password12345";

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

        $ns = new PersonalNamesSURegister( 'array', $data );
    }
}
