<?php

use opensrs\domains\personalnames\PersonalNamesSURegister;

/**
 * @group personalnames
 * @group PersonalNamesSURegister
 */
class PersonalNamesSURegisterSuggestTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persSUregister';

    protected $validSubmission = array(
        'attributes' => array(
            /*
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
            'domain' => '',
            'forward_email' => '',
            'mailbox_type' => '',
            'password' => '',

            /*
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
            'content' => '',
            'name' => '',
            'type' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->mailbox_type = 'MAILBOX';
        $data->attributes->password = 'password12345';

        $ns = new PersonalNamesSURegister('array', $data);

        $this->assertTrue($ns instanceof PersonalNamesSURegister);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
            'missing mailbox_type' => array('mailbox_type'),
            'missing password' => array('password'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->mailbox_type = 'MAILBOX';
        $data->attributes->password = 'password12345';

        if (is_null($message)) {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$field.*not defined/"
              );
        } else {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$message/"
              );
        }

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new PersonalNamesSURegister('array', $data);
    }
}
