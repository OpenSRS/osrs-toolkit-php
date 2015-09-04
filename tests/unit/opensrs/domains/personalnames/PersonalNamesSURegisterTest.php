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
            "func" => "persSUregister",

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
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->mailbox_type = "MAILBOX";
        $data->data->password = "password12345";


        $ns = new PersonalNamesSURegister( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->mailbox_type = "MAILBOX";
        $data->data->password = "password12345";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no domain sent
        unset( $data->data->domain );
        $ns = new PersonalNamesSURegister( 'array', $data );



        // no mailbox_type sent
        unset( $data->data->mailbox_type );
        $ns = new PersonalNamesSURegister( 'array', $data );



        // no password sent
        unset( $data->data->password );
        $ns = new PersonalNamesSURegister( 'array', $data );
    }
}
