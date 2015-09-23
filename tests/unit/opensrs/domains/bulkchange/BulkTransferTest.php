<?php

use opensrs\domains\bulkchange\BulkTransfer;

/**
 * @group bulkchange
 * @group BulkTransfer
 */
class BulkTransferTest extends PHPUnit_Framework_TestCase
{
    protected $change_types = array(
        'availability_check' => 'Availability_check',
        'dns_zone' => 'Dns_zone',
        'dns_zone_record' => 'Dns_zone_record',
        'domain_contacts' => 'Domain_contacts',
        'domain_forwarding' => 'Domain_forwarding',
        'domain_lock' => 'Domain_lock',
        'domain_nameservers' => 'Domain_nameservers',
        'domain_parked_pages' => 'Domain_parked_pages',
        'domain_renew' => 'Domain_renew',
        'push_domains' => 'Push_domains',
        'whois_privacy' => 'Whois_privacy',
        );
    protected $validSubmission = array(
        'attributes' => array(
            'reg_username' => '',
            'reg_domain' => '',
            'reg_password' => '',

            'custom_tech_contact' => '',
            'domain_list' => '',

            'contact_set' => array(
                'owner' => '',
                'admin' => '',
                'billing' => '',
                'tech' => '',
                ),

            'affiliate_id' => '',
            'handle' => '',
            'registrant_ip' => '',
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

        $data->attributes->reg_username = 'phptest';
        $data->attributes->reg_password = 'password1234';
        $data->attributes->reg_domain = 'phptest'.time().'.com';

        $data->attributes->custom_tech_contact = 'techcontact';
        $data->attributes->domain_list = array('phptest.com', 'phptest.net');

        $data->attributes->contact_set->owner = new \stdClass();
        $data->attributes->contact_set->owner->first_name = 'Tikloot';
        $data->attributes->contact_set->owner->last_name = 'Php';

        $data->attributes->contact_set->admin = $data->attributes->contact_set->owner;
        $data->attributes->contact_set->billing = $data->attributes->contact_set->owner;
        $data->attributes->contact_set->tech = $data->attributes->contact_set->owner;

        $data->attributes->affiliate_id = time();
        $data->attributes->handle = 'test';
        $data->attributes->registrant_ip = long2ip(time());

        $ns = new BulkTransfer('array', $data);

        $this->assertTrue($ns instanceof BulkTransfer);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing reg_password' => array('custom_tech_contact'),
            'missing reg_username' => array('domain_list'),
            'missing domain_list' => array('reg_username'),
            'missing custom_tech_contact' => array('reg_password'),
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

        $data->attributes->reg_username = 'phptest';
        $data->attributes->reg_password = 'password1234';
        $data->attributes->reg_domain = 'phptest'.time().'.com';

        $data->attributes->custom_tech_contact = 'techcontact';
        $data->attributes->domain_list = array('phptest.com', 'phptest.net');

        $data->attributes->contact_set->owner = new \stdClass();
        $data->attributes->contact_set->owner->first_name = 'Tikloot';
        $data->attributes->contact_set->owner->last_name = 'Php';

        $data->attributes->contact_set->admin = $data->attributes->contact_set->owner;
        $data->attributes->contact_set->billing = $data->attributes->contact_set->owner;
        $data->attributes->contact_set->tech = $data->attributes->contact_set->owner;

        $data->attributes->affiliate_id = time();
        $data->attributes->handle = 'test';
        $data->attributes->registrant_ip = long2ip(time());

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

        $ns = new BulkTransfer('array', $data);
    }
}
