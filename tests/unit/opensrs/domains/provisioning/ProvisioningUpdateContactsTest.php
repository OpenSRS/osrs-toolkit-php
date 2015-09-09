<?php

use OpenSRS\domains\provisioning\ProvisioningUpdateContacts;
/**
 * @group provisioning
 * @group ProvisioningUpdateContacts
 */
class ProvisioningUpdateContactsTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provUpdateContacts';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provUpdateContacts",

            /**
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: relevant domain, required
             *   only if cookie is not sent
             */
            "cookie" => "",
            "domain" => "",
            ),
        /**
         * Required
         *
         * NOTE THE FOLLOWING ARE SIBLING ENTRIES
         * TO ->data, THEY ARE NOT CHILDREN
         *
         * personal: associative array
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
        "personal" => array(
            "first_name" => "",
            "last_name" => "",
            "org_name" => "",
            "address1" => "",
            // address2 optional
            "address2" => "",
            // address3 optional
            "address3" => "",
            "city" => "",
            "state" => "",
            "country" => "",
            "postal_code" => "",
            "phone" => "",
            "fax" => "",
            "email" => "",
            "url" => "",
            "lang_pref" => ""
            ),
        "admin" => array(
            "first_name" => "",
            "last_name" => "",
            "org_name" => "",
            "address1" => "",
            // address2 optional
            "address2" => "",
            // address3 optional
            "address3" => "",
            "city" => "",
            "state" => "",
            "country" => "",
            "postal_code" => "",
            "phone" => "",
            "fax" => "",
            "email" => "",
            "url" => "",
            "lang_pref" => ""
            ),
        "tech" => array(
            "first_name" => "",
            "last_name" => "",
            "org_name" => "",
            "address1" => "",
            // address2 optional
            "address2" => "",
            // address3 optional
            "address3" => "",
            "city" => "",
            "state" => "",
            "country" => "",
            "postal_code" => "",
            "phone" => "",
            "fax" => "",
            "email" => "",
            "url" => "",
            "lang_pref" => ""
            ),
        "billing" => array(
            "first_name" => "",
            "last_name" => "",
            "org_name" => "",
            "address1" => "",
            // address2 optional
            "address2" => "",
            // address3 optional
            "address3" => "",
            "city" => "",
            "state" => "",
            "country" => "",
            "postal_code" => "",
            "phone" => "",
            "fax" => "",
            "email" => "",
            "url" => "",
            "lang_pref" => ""
            ),
        );

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing personal' => array('personal', null),
            'missing admin' => array('admin', null),
            'missing tech' => array('tech', null),
            'missing billing' => array('billing', null),

            'missing personal->first_name' => array('first_name', 'personal'),
            'missing personal->last_name' => array('last_name', 'personal'),
            'missing personal->org_name' => array('org_name', 'personal'),
            'missing personal->address1' => array('address1', 'personal'),
            'missing personal->city' => array('city', 'personal'),
            'missing personal->state' => array('state', 'personal'),
            'missing personal->country' => array('country', 'personal'),
            'missing personal->postal_code' => array('postal_code', 'personal'),
            'missing personal->phone' => array('phone', 'personal'),
            'missing personal->email' => array('email', 'personal'),
            'missing personal->lang_pref' => array('lang_pref', 'personal'),

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
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->types = "owner,admin,tech,billing";

        $data->personal->first_name = "John";
        $data->personal->last_name = "Smith";
        $data->personal->org_name = "Tucows";
        $data->personal->address1 = "96 Mowat Avenue";
        $data->personal->address2 = "";
        $data->personal->address3 = "";
        $data->personal->city = "Toronto";
        $data->personal->state = "ON";
        $data->personal->country = "CA";
        $data->personal->postal_code = "M6K 3M1";
        $data->personal->phone = "+1.4165350123";
        $data->personal->email = "phptoolkit@tucows.com";
        $data->personal->lang_pref = "EN";

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->admin = $data->personal;
        $data->tech = $data->personal;
        $data->billing = $data->personal;

        $ns = new ProvisioningUpdateContacts( 'array', $data );

        $this->assertTrue( $ns instanceof ProvisioningUpdateContacts );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
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
        $data->data->types = "owner,admin,tech,billing";

        $data->personal->first_name = "John";
        $data->personal->last_name = "Smith";
        $data->personal->org_name = "Tucows";
        $data->personal->address1 = "96 Mowat Avenue";
        $data->personal->address2 = "";
        $data->personal->address3 = "";
        $data->personal->city = "Toronto";
        $data->personal->state = "ON";
        $data->personal->country = "CA";
        $data->personal->postal_code = "M6K 3M1";
        $data->personal->phone = "+1.4165350123";
        $data->personal->email = "phptoolkit@tucows.com";
        $data->personal->lang_pref = "EN";

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->admin = $data->personal;
        $data->tech = $data->personal;
        $data->billing = $data->personal;

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

        $ns = new ProvisioningUpdateContacts( 'array', $data );
    }
}
