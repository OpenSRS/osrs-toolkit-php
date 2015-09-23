<?php

use opensrs\domains\personalnames\PersonalNamesUpdate;

/**
 * @group personalnames
 * @group PersonalNamesUpdate
 */
class PersonalNamesUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persUpdate';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain: domain name to register
             */
            'domain' => '',

            /*
             * Optional
             * 
             * Values used for email account
             * associated with the domain
             *
             * disable_forward_email: disable email
             *   forwarding. to enable, use 
             *   'forward_email' parameter. allowed
             *   value is 1.
             * forward_email: address to which
             *   email is forwarded to
             * mailbox_type: 'MAILBOX' or 'WEBMAIL_ONLY'
             *   (no IMAP/POP/SMTP)
             * password: registrant's new email
             *   password
             */
            'disable_forward_email' => '',
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
             *
             * IMPORTANT: if you update dnsRecords, you
             *   must provide a full list of records.
             *   any committed records will be deleted.
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

        $data->attributes->domain = 'john.smith.net';

        $ns = new PersonalNamesUpdate('array', $data);

        $this->assertTrue($ns instanceof PersonalNamesUpdate);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
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

        $data->attributes->domain = 'john.smith.net';

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

        $ns = new PersonalNamesUpdate('array', $data);
    }
}
