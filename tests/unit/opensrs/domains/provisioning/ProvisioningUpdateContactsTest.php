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
         * tech_contact: associative array
         *   containing contact information for
         *   domain technical contact
         * billing_contact: associative array
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
    public function testInvalidSubmissionFieldsMissing() {
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

        $this->setExpectedException( 'OpenSRS\Exception' );



        // not sending domain
        unset($data->data->domain);
        $ns = new ProvisioningUpdateContacts( 'array', $data );
     }
}
