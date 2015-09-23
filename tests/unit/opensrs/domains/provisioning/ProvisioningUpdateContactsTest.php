<?php

use opensrs\domains\provisioning\ProvisioningUpdateContacts;

/**
 * @group provisioning
 * @group ProvisioningUpdateContacts
 */
class ProvisioningUpdateContactsTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provUpdateContacts';

    protected $validSubmission = array(
                'attributes' => array(
                        /*
                         * Required: 1 of 2
                         *
                         * cookie: cookie to be deleted
                         * domain: relevant domain, required
                         *   only if cookie is not sent
                         * owner: associative array
                         *   containing contact information for
                         *   domain owner
                         * admin: associative array
                         *   containing contact information for
                         *   domain admin contact
                         * tech: associative array
                         *   containing contact information for
                         *   domain technical contact
                         * billing: associative array
                         *   containing contact information for
                         *   domain billing contact
                         */
                        'cookie' => '',
                        'domain' => '',

                        'contact_set' => array(
                            'owner' => array(
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
                                    'url' => '',
                                    'lang_pref' => '',
                                    ),
                            'admin' => array(
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
                                    'url' => '',
                                    'lang_pref' => '',
                                    ),
                            'tech' => array(
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
                                    'url' => '',
                                    'lang_pref' => '',
                                    ),
                            'billing' => array(
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
                                    'url' => '',
                                    'lang_pref' => '',
                                    ),
                            ),
                        ),
                );

        /**
         * Data Provider for Invalid Submission test.
         */
        public function submissionFields()
        {
            return array(
                        'missing domain' => array('domain'),
                        'missing types' => array('types'),
                        );
        }

        /**
         * Data Provider for Invalid Submission test.
         */
        public function submissionContactFields()
        {
            return array(
                        'missing owner' => array('owner', null),
                        'missing admin' => array('admin', null),
                        'missing tech' => array('tech', null),
                        'missing billing' => array('billing', null),

                        'missing owner->first_name' => array('first_name', 'owner'),
                        'missing owner->last_name' => array('last_name', 'owner'),
                        'missing owner->org_name' => array('org_name', 'owner'),
                        'missing owner->address1' => array('address1', 'owner'),
                        'missing owner->city' => array('city', 'owner'),
                        'missing owner->state' => array('state', 'owner'),
                        'missing owner->country' => array('country', 'owner'),
                        'missing owner->postal_code' => array('postal_code', 'owner'),
                        'missing owner->phone' => array('phone', 'owner'),
                        'missing owner->email' => array('email', 'owner'),
                        'missing owner->lang_pref' => array('lang_pref', 'owner'),

                        'missing admin->first_name' => array('first_name', 'admin'),
                        'missing admin->last_name' => array('last_name', 'admin'),
                        'missing admin->org_name' => array('org_name', 'admin'),
                        'missing admin->address1' => array('address1', 'admin'),
                        'missing admin->city' => array('city', 'admin'),
                        'missing admin->state' => array('state', 'admin'),
                        'missing admin->country' => array('country', 'admin'),
                        'missing admin->postal_code' => array('postal_code', 'admin'),
                        'missing admin->phone' => array('phone', 'admin'),
                        'missing admin->email' => array('email', 'admin'),
                        'missing admin->lang_pref' => array('lang_pref', 'admin'),

                        'missing tech->first_name' => array('first_name', 'tech'),
                        'missing tech->last_name' => array('last_name', 'tech'),
                        'missing tech->org_name' => array('org_name', 'tech'),
                        'missing tech->address1' => array('address1', 'tech'),
                        'missing tech->city' => array('city', 'tech'),
                        'missing tech->state' => array('state', 'tech'),
                        'missing tech->country' => array('country', 'tech'),
                        'missing tech->postal_code' => array('postal_code', 'tech'),
                        'missing tech->phone' => array('phone', 'tech'),
                        'missing tech->email' => array('email', 'tech'),
                        'missing tech->lang_pref' => array('lang_pref', 'tech'),

                        'missing billing->first_name' => array('first_name', 'billing'),
                        'missing billing->last_name' => array('last_name', 'billing'),
                        'missing billing->org_name' => array('org_name', 'billing'),
                        'missing billing->address1' => array('address1', 'billing'),
                        'missing billing->city' => array('city', 'billing'),
                        'missing billing->state' => array('state', 'billing'),
                        'missing billing->country' => array('country', 'billing'),
                        'missing billing->postal_code' => array('postal_code', 'billing'),
                        'missing billing->phone' => array('phone', 'billing'),
                        'missing billing->email' => array('email', 'billing'),
                        'missing billing->lang_pref' => array('lang_pref', 'billing'),
                        );
        }

        /**
         * Valid submission should not throw an exception.
         *
         *
         * @group validsubmission
         */
        public function testValidSubmission()
        {
            $data = json_decode(json_encode($this->validSubmission));

            $data->attributes->domain = 'phptest'.time().'.com';
            $data->attributes->types = 'owner,admin,tech,billing';

            $data->attributes->contact_set->owner->first_name = 'John';
            $data->attributes->contact_set->owner->last_name = 'Smith';
            $data->attributes->contact_set->owner->org_name = 'Tucows';
            $data->attributes->contact_set->owner->address1 = '96 Mowat Avenue';
            $data->attributes->contact_set->owner->address2 = '';
            $data->attributes->contact_set->owner->address3 = '';
            $data->attributes->contact_set->owner->city = 'Toronto';
            $data->attributes->contact_set->owner->state = 'ON';
            $data->attributes->contact_set->owner->country = 'CA';
            $data->attributes->contact_set->owner->postal_code = 'M6K 3M1';
            $data->attributes->contact_set->owner->phone = '+1.4165350123';
            $data->attributes->contact_set->owner->email = 'phptoolkit@tucows.com';
            $data->attributes->contact_set->owner->lang_pref = 'EN';

                // We're going to use the same contact for all 4
                // contact types, but we still need to assign
                // it to each element on the data object
                $data->attributes->contact_set->admin = $data->attributes->contact_set->owner;
            $data->attributes->contact_set->tech = $data->attributes->contact_set->owner;
            $data->attributes->contact_set->billing = $data->attributes->contact_set->owner;

            $ns = new ProvisioningUpdateContacts('array', $data);

            $this->assertTrue($ns instanceof ProvisioningUpdateContacts);
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
            $data->attributes->types = 'owner,admin,tech,billing';

            $data->attributes->contact_set->owner->first_name = 'John';
            $data->attributes->contact_set->owner->last_name = 'Smith';
            $data->attributes->contact_set->owner->org_name = 'Tucows';
            $data->attributes->contact_set->owner->address1 = '96 Mowat Avenue';
            $data->attributes->contact_set->owner->address2 = '';
            $data->attributes->contact_set->owner->address3 = '';
            $data->attributes->contact_set->owner->city = 'Toronto';
            $data->attributes->contact_set->owner->state = 'ON';
            $data->attributes->contact_set->owner->country = 'CA';
            $data->attributes->contact_set->owner->postal_code = 'M6K 3M1';
            $data->attributes->contact_set->owner->phone = '+1.4165350123';
            $data->attributes->contact_set->owner->email = 'phptoolkit@tucows.com';
            $data->attributes->contact_set->owner->lang_pref = 'EN';

                // We're going to use the same contact for all 4
                // contact types, but we still need to assign
                // it to each element on the data object
                $data->attributes->contact_set->admin = $data->attributes->contact_set->owner;
            $data->attributes->contact_set->tech = $data->attributes->contact_set->owner;
            $data->attributes->contact_set->billing = $data->attributes->contact_set->owner;

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

            $ns = new ProvisioningUpdateContacts('array', $data);
        }

        /**
         * Invalid submission should throw an exception.
         *
         *
         * @dataProvider submissionContactFields
         * @group invalidsubmission
         */
        public function testInvalidSubmissionContactFieldsMissing($field, $parent = 'attributes', $message = null)
        {
            $data = json_decode(json_encode($this->validSubmission));

            $data->attributes->domain = 'phptest'.time().'.com';
            $data->attributes->types = 'owner,admin,tech,billing';

            $data->attributes->contact_set->owner->first_name = 'John';
            $data->attributes->contact_set->owner->last_name = 'Smith';
            $data->attributes->contact_set->owner->org_name = 'Tucows';
            $data->attributes->contact_set->owner->address1 = '96 Mowat Avenue';
            $data->attributes->contact_set->owner->address2 = '';
            $data->attributes->contact_set->owner->address3 = '';
            $data->attributes->contact_set->owner->city = 'Toronto';
            $data->attributes->contact_set->owner->state = 'ON';
            $data->attributes->contact_set->owner->country = 'CA';
            $data->attributes->contact_set->owner->postal_code = 'M6K 3M1';
            $data->attributes->contact_set->owner->phone = '+1.4165350123';
            $data->attributes->contact_set->owner->email = 'phptoolkit@tucows.com';
            $data->attributes->contact_set->owner->lang_pref = 'EN';

                // We're going to use the same contact for all 4
                // contact types, but we still need to assign
                // it to each element on the data object
                $data->attributes->contact_set->admin = $data->attributes->contact_set->owner;
            $data->attributes->contact_set->tech = $data->attributes->contact_set->owner;
            $data->attributes->contact_set->billing = $data->attributes->contact_set->owner;

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

            $ns = new ProvisioningUpdateContacts('array', $data);
        }
}
