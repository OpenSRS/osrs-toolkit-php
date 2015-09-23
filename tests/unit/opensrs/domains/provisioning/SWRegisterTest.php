<?php

use opensrs\domains\provisioning\SWRegister;

/**
 * @group provisioning
 * @group SWRegister
 */
class SWRegisterTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'contact_set' => array(
                'owner' => '',
                'admin' => '',
                'billing' => '',
                'tech' => '',
                ),
            'custom_nameservers' => '',
            'custom_tech_contact' => '',
            'domain' => '',
            'handle' => '',

            'period' => '',
            'reg_username' => '',
            'reg_password' => '',
            'reg_type' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown.
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.com';

        $data->attributes->contact_set = new \stdClass();
        $data->attributes->contact_set->owner = new \stdClass();

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

        $data->attributes->custom_nameservers = '0';
        $data->attributes->custom_tech_contact = '0';
        $data->attributes->handle = 'save';
        $data->attributes->period = '1';
        $data->attributes->reg_username = 'phptest'.time();
        $data->attributes->reg_password = 'password1234';
        $data->attributes->reg_type = 'new';

        $ns = new SWRegister('array', $data);

        $this->assertTrue($ns instanceof SWRegister);
    }

    /**
     * Registration should just strip www. from the domain
     * if passed and not throw an exception.
     */
    public function testRemovesWww()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'www.phptest'.time().'.com';

        $data->attributes->contact_set = new \stdClass();
        $data->attributes->contact_set->owner = new \stdClass();

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

        $data->attributes->custom_nameservers = '0';
        $data->attributes->custom_tech_contact = '0';
        $data->attributes->handle = 'save';
        $data->attributes->period = '1';
        $data->attributes->reg_username = 'phptest'.time();
        $data->attributes->reg_password = 'password1234';
        $data->attributes->reg_type = 'new';

        $ns = new SWRegister('array', $data);

        $this->assertTrue($ns instanceof SWRegister);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
            'missing custom_nameservers' => array('custom_nameservers'),
            'missing custom_tech_contact' => array('custom_tech_contact'),
            'missing period' => array('period'),
            'missing reg_username' => array('reg_username'),
            'missing reg_password' => array('reg_password'),
            'missing reg_type' => array('reg_type'),
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

        $data->attributes->domain = 'www.phptest'.time().'.com';

        $data->attributes->contact_set = new \stdClass();
        $data->attributes->contact_set->owner = new \stdClass();

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

        $data->attributes->custom_nameservers = '0';
        $data->attributes->custom_tech_contact = '0';
        $data->attributes->handle = 'save';
        $data->attributes->period = '1';
        $data->attributes->reg_username = 'phptest'.time();
        $data->attributes->reg_password = 'password1234';
        $data->attributes->reg_type = 'new';

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

        $ns = new SWRegister('array', $data);
    }
}
