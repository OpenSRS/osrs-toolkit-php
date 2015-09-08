<?php

use OpenSRS\domains\provisioning\ProvisioningModify;
/**
 * @group provisioning
 * @group ProvisioningModify
 */
class ProvisioningModifyTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provModify';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provModify",

            /**
             * Required: 1 of 2
             *
             * cookie: cookie to be changed
             * domain: relevant domain, required
             *   only if cookie is not sent
             *   NOTE: class uses domain_name
             *         and not "domain" for this
             *         field's name
             */
            "cookie" => "",
            // "domain" => "",
            "domain_name" => "",

            /**
             * Required
             *
             * affected_domains: flag indicating
             *   the domains to which to apply the
             *   change. values:
             *     - 0 = only specified domain
             *     - 1 = all domains linked to this
             *           profile
             * data: type of data being sent (see API docs)
             * tld_data: associative array containing
             *   additional information required by the
             *   registry. required for .ASIA, .COOP,
             *   .JOBS, .LV, .MX, .PRO, .RO, .US, .ZA.
             *   optional for: .XXX. see API docs.
             */
            "affect_domains" => "",
            "data" => "",
            "tld_data" => "",
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
        $data->data->affect_domains = "0";

        $data->data->data = 'status';
        $data->data->lock_state = "locked";
        $data->data->domain_name = $data->data->domain;



        $ns = new ProvisioningModify( 'array', $data );
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

        $this->setExpectedException( 'OpenSRS\Exception' );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->affect_domains = "0";

        $data->data->data = 'status';
        $data->data->lock_state = "locked";
        $data->data->domain_name = $data->data->domain;


        // no change_type (data->data) sent
        unset( $data->data->data );
        $ns = new ProvisioningModify( 'array', $data );
     }
}
