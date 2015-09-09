<?php

use OpenSRS\domains\subreseller\SubresellerCreate;
/**
 * @group subreseller
 * @group SubresellerCreate
 */
class SubresellerCreateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subresCreate';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * cpp_enabled: indicates if credit card
             *   payments are enabled for sub-reseller
             *   values:
             *     - N = no
             *     - Y = yes
             * low_balance_email: email address to
             *   send notice when balance falls to a
             *   predefined level
             * username: username for the sub-reseller
             * password: password for the new sub-
             *   reseller account
             * pricing_plan: pricing plan assigned to
             *   the sub-reseller
             * status: status of the account, accepted
             *   values: active, onhold, locked,
             *           cancelled, paid_only
             * system_status_email: email address that
             *   will receive system status messages
             */
            "ccp_enabled" => "",
            "low_balance_email" => "",
            "username" => "",
            "password" => "",
            "pricing_plan" => "",
            "status" => "",
            "system_status_email" => "",

            /**
             * Optional
             *
             * url: web address of the account
             * nameservers: list of default nameservers
             *   for the sub-reseller
             */
            "url" => "",
            "nameservers" => "",
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
         *   Note: admin, billing, tech contacts
         *         are also supported. 'admin'
         *         contact is the sub-reseller's
         *         emergency contact, not domain
         *         admin contact
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

        $data->data->username = "subreseller" . time();
        $data->data->password = "password1234";
        $data->data->ccp_enabled = "Y";
        $data->data->pricing_plan = "1";
        $data->data->status = "onhold";
        $data->data->low_balance_email = "phptoolkit@tucows.com";
        $data->data->system_status_email = "phptoolkit@tucows.com";

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

        $ns = new SubresellerCreate( 'array', $data );

        $this->assertTrue( $ns instanceof SubresellerCreate );
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

        $data->data->username = "subreseller" . time();
        $data->data->password = "password1234";
        $data->data->ccp_enabled = "Y";
        $data->data->pricing_plan = "1";
        $data->data->status = "onhold";
        $data->data->low_balance_email = "phptoolkit@tucows.com";
        $data->data->system_status_email = "phptoolkit@tucows.com";

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

        $this->setExpectedException( 'OpenSRS\Exception' );



        // not sending username or password
        unset(
            $data->data->username,
            $data->data->password
            );
        $ns = new SubresellerCreate( 'array', $data );
     }
}
