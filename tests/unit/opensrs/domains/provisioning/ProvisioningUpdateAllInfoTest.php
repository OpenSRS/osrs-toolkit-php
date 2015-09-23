<?php

use opensrs\domains\provisioning\ProvisioningUpdateAllInfo;

/**
 * @group provisioning
 * @group ProvisioningUpdateAllInfo
 */
class ProvisioningUpdateAllInfoTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provUpdateAllInfo';

    protected $validSubmission = array(
        'cookie' => '',

        'attributes' => array(
            /*
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: relevant domain, required
             *   only if cookie is not sent
             */
            'domain' => '',

            /*
             * Required
             *
             * owner_contact: associative array
             *   containing contact information for
             *   domain owner
             * admin_contact: associative array
             *   containing contact information for
             *   domain admin contact
             * tech_contact: associative array
             *   containing contact information for
             *   domain technical contact
             * billing_contact: associative array
             *   containing contact information for
             *   domain billing contact
             * nameserver_names: comma-separated list
             *   of FQDN for each nameserver being
             *   sent
             * nameserver_ips: CSV list of IPs for
             *   nameservers being sent, must be in
             *   the same order as nameserver_names
             */
            'contact_set' => array(
              'owner_contact' => array(
                  'first_name' => '',
                  'last_name' => '',
                  'org_name' => '',
                  'address1' => '',
                  // address2 optional
                  'address2' => '',
                  // address3 optional
                  'address3' => '',
                  'city' => '',
                  'state' => '',
                  'country' => '',
                  'postal_code' => '',
                  'phone' => '',
                  'fax' => '',
                  'email' => '',
                  'lang_pref' => '',
                  ),
              'admin_contact' => array(
                  'first_name' => '',
                  'last_name' => '',
                  'org_name' => '',
                  'address1' => '',
                  // address2 optional
                  'address2' => '',
                  // address3 optional
                  'address3' => '',
                  'city' => '',
                  'state' => '',
                  'country' => '',
                  'postal_code' => '',
                  'phone' => '',
                  'fax' => '',
                  'email' => '',
                  'lang_pref' => '',
                  ),
              'tech_contact' => array(
                  'first_name' => '',
                  'last_name' => '',
                  'org_name' => '',
                  'address1' => '',
                  // address2 optional
                  'address2' => '',
                  // address3 optional
                  'address3' => '',
                  'city' => '',
                  'state' => '',
                  'country' => '',
                  'postal_code' => '',
                  'phone' => '',
                  'fax' => '',
                  'email' => '',
                  'lang_pref' => '',
                  ),
              'billing_contact' => array(
                  'first_name' => '',
                  'last_name' => '',
                  'org_name' => '',
                  'address1' => '',
                  // address2 optional
                  'address2' => '',
                  // address3 optional
                  'address3' => '',
                  'city' => '',
                  'state' => '',
                  'country' => '',
                  'postal_code' => '',
                  'phone' => '',
                  'fax' => '',
                  'email' => '',
                  'lang_pref' => '',
                  ),
                ),
            'nameserver_names' => '',
            'nameserver_ips' => '',
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

        $data->attributes->contact_set->owner_contact->first_name = 'John';
        $data->attributes->contact_set->owner_contact->last_name = 'Smith';
        $data->attributes->contact_set->owner_contact->org_name = 'Tucows';
        $data->attributes->contact_set->owner_contact->address1 = '96 Mowat Avenue';
        $data->attributes->contact_set->owner_contact->address2 = '';
        $data->attributes->contact_set->owner_contact->address3 = '';
        $data->attributes->contact_set->owner_contact->city = 'Toronto';
        $data->attributes->contact_set->owner_contact->state = 'ON';
        $data->attributes->contact_set->owner_contact->country = 'CA';
        $data->attributes->contact_set->owner_contact->postal_code = 'M6K 3M1';
        $data->attributes->contact_set->owner_contact->phone = '+1.4165350123';
        $data->attributes->contact_set->owner_contact->email = 'phptoolkit@tucows.com';
        $data->attributes->contact_set->owner_contact->lang_pref = 'EN';

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->attributes->contact_set->admin_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->tech_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->billing_contact = $data->attributes->contact_set->owner_contact;

        $data->attributes->nameserver_names = 'ns1.'.$data->attributes->domain.','.
                                        'ns2.'.$data->attributes->domain;

        $data->attributes->nameserver_ips = long2ip(mt_rand()).','.
                                      long2ip(mt_rand());

        $ns = new ProvisioningUpdateAllInfo('array', $data);

        $this->assertTrue($ns instanceof ProvisioningUpdateAllInfo);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing nameserver_names' => array('nameserver_names', 'attributes', 'requires.*nameserver'),
            'missing domain' => array('domain'),
            );
    }

    /**
     * Data Provider for Invalid Contact Submission test.
     */
    public function submissionContactsFields()
    {
        return array(
            'missing owner_contact' => array('owner_contact', null),
            'missing admin_contact' => array('admin_contact', null),
            'missing tech_contact' => array('tech_contact', null),
            'missing billing_contact' => array('billing_contact', null),

            'missing owner_contact->first_name' => array('first_name', 'owner_contact'),
            'missing owner_contact->last_name' => array('last_name', 'owner_contact'),
            'missing owner_contact->org_name' => array('org_name', 'owner_contact'),
            'missing owner_contact->address1' => array('address1', 'owner_contact'),
            'missing owner_contact->city' => array('city', 'owner_contact'),
            'missing owner_contact->state' => array('state', 'owner_contact'),
            'missing owner_contact->country' => array('country', 'owner_contact'),
            'missing owner_contact->postal_code' => array('postal_code', 'owner_contact'),
            'missing owner_contact->phone' => array('phone', 'owner_contact'),
            'missing owner_contact->email' => array('email', 'owner_contact'),
            'missing owner_contact->lang_pref' => array('lang_pref', 'owner_contact'),

            'missing admin_contact->first_name' => array('first_name', 'admin_contact'),
            'missing admin_contact->last_name' => array('last_name', 'admin_contact'),
            'missing admin_contact->org_name' => array('org_name', 'admin_contact'),
            'missing admin_contact->address1' => array('address1', 'admin_contact'),
            'missing admin_contact->city' => array('city', 'admin_contact'),
            'missing admin_contact->state' => array('state', 'admin_contact'),
            'missing admin_contact->country' => array('country', 'admin_contact'),
            'missing admin_contact->postal_code' => array('postal_code', 'admin_contact'),
            'missing admin_contact->phone' => array('phone', 'admin_contact'),
            'missing admin_contact->email' => array('email', 'admin_contact'),
            'missing admin_contact->lang_pref' => array('lang_pref', 'admin_contact'),

            'missing tech_contact->first_name' => array('first_name', 'tech_contact'),
            'missing tech_contact->last_name' => array('last_name', 'tech_contact'),
            'missing tech_contact->org_name' => array('org_name', 'tech_contact'),
            'missing tech_contact->address1' => array('address1', 'tech_contact'),
            'missing tech_contact->city' => array('city', 'tech_contact'),
            'missing tech_contact->state' => array('state', 'tech_contact'),
            'missing tech_contact->country' => array('country', 'tech_contact'),
            'missing tech_contact->postal_code' => array('postal_code', 'tech_contact'),
            'missing tech_contact->phone' => array('phone', 'tech_contact'),
            'missing tech_contact->email' => array('email', 'tech_contact'),
            'missing tech_contact->lang_pref' => array('lang_pref', 'tech_contact'),

            'missing billing_contact->first_name' => array('first_name', 'billing_contact'),
            'missing billing_contact->last_name' => array('last_name', 'billing_contact'),
            'missing billing_contact->org_name' => array('org_name', 'billing_contact'),
            'missing billing_contact->address1' => array('address1', 'billing_contact'),
            'missing billing_contact->city' => array('city', 'billing_contact'),
            'missing billing_contact->state' => array('state', 'billing_contact'),
            'missing billing_contact->country' => array('country', 'billing_contact'),
            'missing billing_contact->postal_code' => array('postal_code', 'billing_contact'),
            'missing billing_contact->phone' => array('phone', 'billing_contact'),
            'missing billing_contact->email' => array('email', 'billing_contact'),
            'missing billing_contact->lang_pref' => array('lang_pref', 'billing_contact'),
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

        $data->attributes->contact_set->owner_contact->first_name = 'John';
        $data->attributes->contact_set->owner_contact->last_name = 'Smith';
        $data->attributes->contact_set->owner_contact->org_name = 'Tucows';
        $data->attributes->contact_set->owner_contact->address1 = '96 Mowat Avenue';
        $data->attributes->contact_set->owner_contact->address2 = '';
        $data->attributes->contact_set->owner_contact->address3 = '';
        $data->attributes->contact_set->owner_contact->city = 'Toronto';
        $data->attributes->contact_set->owner_contact->state = 'ON';
        $data->attributes->contact_set->owner_contact->country = 'CA';
        $data->attributes->contact_set->owner_contact->postal_code = 'M6K 3M1';
        $data->attributes->contact_set->owner_contact->phone = '+1.4165350123';
        $data->attributes->contact_set->owner_contact->email = 'phptoolkit@tucows.com';
        $data->attributes->contact_set->owner_contact->lang_pref = 'EN';

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->attributes->contact_set->admin_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->tech_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->billing_contact = $data->attributes->contact_set->owner_contact;

        $data->attributes->nameserver_names = 'ns1.'.$data->attributes->domain.','.
                                        'ns2.'.$data->attributes->domain;

        $data->attributes->nameserver_ips = long2ip(mt_rand()).','.
                                      long2ip(mt_rand());

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

        $ns = new ProvisioningUpdateAllInfo('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionContactsFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionContactsFields($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.com';

        $data->attributes->contact_set->owner_contact->first_name = 'John';
        $data->attributes->contact_set->owner_contact->last_name = 'Smith';
        $data->attributes->contact_set->owner_contact->org_name = 'Tucows';
        $data->attributes->contact_set->owner_contact->address1 = '96 Mowat Avenue';
        $data->attributes->contact_set->owner_contact->address2 = '';
        $data->attributes->contact_set->owner_contact->address3 = '';
        $data->attributes->contact_set->owner_contact->city = 'Toronto';
        $data->attributes->contact_set->owner_contact->state = 'ON';
        $data->attributes->contact_set->owner_contact->country = 'CA';
        $data->attributes->contact_set->owner_contact->postal_code = 'M6K 3M1';
        $data->attributes->contact_set->owner_contact->phone = '+1.4165350123';
        $data->attributes->contact_set->owner_contact->email = 'phptoolkit@tucows.com';
        $data->attributes->contact_set->owner_contact->lang_pref = 'EN';

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->attributes->contact_set->admin_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->tech_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->billing_contact = $data->attributes->contact_set->owner_contact;

        $data->attributes->nameserver_names = 'ns1.'.$data->attributes->domain.','.
                                        'ns2.'.$data->attributes->domain;

        $data->attributes->nameserver_ips = long2ip(mt_rand()).','.
                                      long2ip(mt_rand());

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
            unset($data->attributes->contact_set->$field);
        } else {
            unset($data->attributes->contact_set->$parent->$field);
        }

        $ns = new ProvisioningUpdateAllInfo('array', $data);
    }

    public function testInvalidSubmissionFieldsNameserverIPCountMismatch()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.com';

        $data->attributes->contact_set->owner_contact->first_name = 'John';
        $data->attributes->contact_set->owner_contact->last_name = 'Smith';
        $data->attributes->contact_set->owner_contact->org_name = 'Tucows';
        $data->attributes->contact_set->owner_contact->address1 = '96 Mowat Avenue';
        $data->attributes->contact_set->owner_contact->address2 = '';
        $data->attributes->contact_set->owner_contact->address3 = '';
        $data->attributes->contact_set->owner_contact->city = 'Toronto';
        $data->attributes->contact_set->owner_contact->state = 'ON';
        $data->attributes->contact_set->owner_contact->country = 'CA';
        $data->attributes->contact_set->owner_contact->postal_code = 'M6K 3M1';
        $data->attributes->contact_set->owner_contact->phone = '+1.4165350123';
        $data->attributes->contact_set->owner_contact->email = 'phptoolkit@tucows.com';
        $data->attributes->contact_set->owner_contact->lang_pref = 'EN';

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->attributes->contact_set->admin_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->tech_contact = $data->attributes->contact_set->owner_contact;
        $data->attributes->contact_set->billing_contact = $data->attributes->contact_set->owner_contact;

        $data->attributes->nameserver_names = 'ns1.'.$data->attributes->domain.','.
                                        'ns2.'.$data->attributes->domain;

        $data->attributes->nameserver_ips = long2ip(mt_rand()).','.
                                      long2ip(mt_rand());

        $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              '/same number of.*Nameserver IP.*Nameserver names/'
              );

        // sending only one nameserver IP to trigger
        // error when sending different number of
        // nameserver_names and _ips
        $data->attributes->nameserver_ips = long2ip(mt_rand());
        $ns = new ProvisioningUpdateAllInfo('array', $data);
    }
}
