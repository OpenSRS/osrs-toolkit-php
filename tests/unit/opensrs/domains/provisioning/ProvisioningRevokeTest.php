<?php

use OpenSRS\domains\provisioning\ProvisioningRevoke;
/**
 * @group provisioning
 * @group ProvisioningRevoke
 */
class ProvisioningRevokeTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provRevoke';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provRevoke",

            /**
             * Required
             *
             * domain: domain to be revoked
             * reseller: reseller username
             *   NOTE: reseller not listed in API
             *         documentation
             */
            "domain" => "",
            "reseller" => "",

            /**
             * Optional
             *
             * notes: information relevant to action,
             *   notes are saved to domain notes
             */
            "notes" => "",
            )
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
        $data->data->reseller = "reseller_username";

        $ns = new ProvisioningRevoke( 'array', $data );
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
        $data->data->reseller = "reseller_username";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no domain sent
        unset( $data->data->domain );
        $ns = new ProvisioningRevoke( 'array', $data );



        // no reseller sent
        unset( $data->data->reseller );
        $ns = new ProvisioningRevoke( 'array', $data );
     }
}
