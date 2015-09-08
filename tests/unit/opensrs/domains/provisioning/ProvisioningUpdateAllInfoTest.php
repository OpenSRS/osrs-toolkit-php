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
            "func" => "provUpdateAllInfo",

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
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing() {
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

        $this->setExpectedException( 'OpenSRS\Exception' );



        // sending only one nameserver IP to trigger
        // error when sending different number of
        // nameserver_names and _ips
        $data->data->nameserver_ips = long2ip(mt_rand());
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );
        $this->assertTrue( false );



        // not sending nameserver_names
        unset($data->data->nameserver_names);
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );



        // sending billing_contact with missing name
        unset($data->data->billing_contact->first_name);
        unset($data->data->billing_contact->last_name);
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );



        // not sending billing_contact
        unset($data->data->billing_contact);
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );



        // not sending tech_contact
        unset($data->data->tech_contact);
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );



        // not sending admin_contact
        unset($data->data->admin_contact);
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );



        // not sending owner_contact
        unset($data->data->owner_contact);
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );



        // not sending domain
        unset($data->data->domain);
        $ns = new ProvisioningUpdateAllInfo( 'array', $data );
     }
}
