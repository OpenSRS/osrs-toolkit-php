<?php

use OpenSRS\domains\provisioning\ProvisioningUpdateAllInfo;
/**
 * @group provisioning
 * @group ProvisioningUpdateAllInfo
 */
class ProvisioningUpdateAllInfoTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provUpdateAllInfo';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: relevant domain, required
             *   only if cookie is not sent
             */
            "cookie" => "",
            "domain" => "",

            /**
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
            "owner_contact" => array(
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
                "lang_pref" => ""
                ),
            "admin_contact" => array(
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
                "lang_pref" => ""
                ),
            "tech_contact" => array(
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
                "lang_pref" => ""
                ),
            "billing_contact" => array(
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
                "lang_pref" => ""
                ),
            "nameserver_names" => "",
            "nameserver_ips" => "",
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
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";

        $data->data->owner_contact->first_name = "John";
        $data->data->owner_contact->last_name = "Smith";
        $data->data->owner_contact->org_name = "Tucows";
        $data->data->owner_contact->address1 = "96 Mowat Avenue";
        $data->data->owner_contact->address2 = "";
        $data->data->owner_contact->address3 = "";
        $data->data->owner_contact->city = "Toronto";
        $data->data->owner_contact->state = "ON";
        $data->data->owner_contact->country = "CA";
        $data->data->owner_contact->postal_code = "M6K 3M1";
        $data->data->owner_contact->phone = "+1.4165350123";
        $data->data->owner_contact->email = "phptoolkit@tucows.com";
        $data->data->owner_contact->lang_pref = "EN";

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->data->admin_contact = $data->data->owner_contact;
        $data->data->tech_contact = $data->data->owner_contact;
        $data->data->billing_contact = $data->data->owner_contact;

        $data->data->nameserver_names = "ns1." . $data->data->domain . "," .
                                        "ns2." . $data->data->domain;

        $data->data->nameserver_ips = long2ip(mt_rand()) . "," .
                                      long2ip(mt_rand());

        $ns = new ProvisioningUpdateAllInfo( 'array', $data );

        $this->assertTrue( $ns instanceof ProvisioningUpdateAllInfo );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing nameserver_names' => array('nameserver_names', 'data', "requires.*nameserver"),
            'missing domain' => array('domain'),
            'missing owner_contact' => array('owner_contact'),
            'missing admin_contact' => array('admin_contact'),
            'missing tech_contact' => array('tech_contact'),
            'missing billing_contact' => array('billing_contact'),
            );
    }

    /**
     * Data Provider for Invalid Contact Submission test
     */
    function submissionContactsFields() {
        return array(
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

        $data->data->owner_contact->first_name = "John";
        $data->data->owner_contact->last_name = "Smith";
        $data->data->owner_contact->org_name = "Tucows";
        $data->data->owner_contact->address1 = "96 Mowat Avenue";
        $data->data->owner_contact->address2 = "";
        $data->data->owner_contact->address3 = "";
        $data->data->owner_contact->city = "Toronto";
        $data->data->owner_contact->state = "ON";
        $data->data->owner_contact->country = "CA";
        $data->data->owner_contact->postal_code = "M6K 3M1";
        $data->data->owner_contact->phone = "+1.4165350123";
        $data->data->owner_contact->email = "phptoolkit@tucows.com";
        $data->data->owner_contact->lang_pref = "EN";

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->data->admin_contact = $data->data->owner_contact;
        $data->data->tech_contact = $data->data->owner_contact;
        $data->data->billing_contact = $data->data->owner_contact;

        $data->data->nameserver_names = "ns1." . $data->data->domain . "," .
                                        "ns2." . $data->data->domain;

        $data->data->nameserver_ips = long2ip(mt_rand()) . "," .
                                      long2ip(mt_rand());

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

        $ns = new ProvisioningUpdateAllInfo( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionContactsFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionContactsFields( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";

        $data->data->owner_contact->first_name = "John";
        $data->data->owner_contact->last_name = "Smith";
        $data->data->owner_contact->org_name = "Tucows";
        $data->data->owner_contact->address1 = "96 Mowat Avenue";
        $data->data->owner_contact->address2 = "";
        $data->data->owner_contact->address3 = "";
        $data->data->owner_contact->city = "Toronto";
        $data->data->owner_contact->state = "ON";
        $data->data->owner_contact->country = "CA";
        $data->data->owner_contact->postal_code = "M6K 3M1";
        $data->data->owner_contact->phone = "+1.4165350123";
        $data->data->owner_contact->email = "phptoolkit@tucows.com";
        $data->data->owner_contact->lang_pref = "EN";

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->data->admin_contact = $data->data->owner_contact;
        $data->data->tech_contact = $data->data->owner_contact;
        $data->data->billing_contact = $data->data->owner_contact;

        $data->data->nameserver_names = "ns1." . $data->data->domain . "," .
                                        "ns2." . $data->data->domain;

        $data->data->nameserver_ips = long2ip(mt_rand()) . "," .
                                      long2ip(mt_rand());

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
            unset( $data->data->$field );
        }
        else{
            unset( $data->data->$parent->$field );
        }

        $ns = new ProvisioningUpdateAllInfo( 'array', $data );
    }

    public function testInvalidSubmissionFieldsNameserverIPCountMismatch() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";

        $data->data->owner_contact->first_name = "John";
        $data->data->owner_contact->last_name = "Smith";
        $data->data->owner_contact->org_name = "Tucows";
        $data->data->owner_contact->address1 = "96 Mowat Avenue";
        $data->data->owner_contact->address2 = "";
        $data->data->owner_contact->address3 = "";
        $data->data->owner_contact->city = "Toronto";
        $data->data->owner_contact->state = "ON";
        $data->data->owner_contact->country = "CA";
        $data->data->owner_contact->postal_code = "M6K 3M1";
        $data->data->owner_contact->phone = "+1.4165350123";
        $data->data->owner_contact->email = "phptoolkit@tucows.com";
        $data->data->owner_contact->lang_pref = "EN";

        // We're going to use the same contact for all 4
        // contact types, but we still need to assign
        // it to each element on the data object
        $data->data->admin_contact = $data->data->owner_contact;
        $data->data->tech_contact = $data->data->owner_contact;
        $data->data->billing_contact = $data->data->owner_contact;

        $data->data->nameserver_names = "ns1." . $data->data->domain . "," .
                                        "ns2." . $data->data->domain;

        $data->data->nameserver_ips = long2ip(mt_rand()) . "," .
                                      long2ip(mt_rand());

          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/same number of.*Nameserver IP.*Nameserver names/"
              );



        // sending only one nameserver IP to trigger
        // error when sending different number of
        // nameserver_names and _ips
        $data->data->nameserver_ips = long2ip(mt_rand());
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );
     }
}
