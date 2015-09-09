<?php

use OpenSRS\domains\provisioning\ProvisioningRenew;
/**
 * @group provisioning
 * @group ProvisioningRenew
 */
class ProvisioningRenewTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provRenew';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provRenew",

            /**
             * Required
             *
             * auto_renew: flag indicating whether the
             *   domain sh9ould auto-renew. values:
             *     - 0 = no auto-renew
             *     - 1 = auto-renew enabled
             * currentexpirationyear: domain's current
             *   expiration year, format YYYY; must match
             *   data in the registry
             * domain: name of the domain to be renewed,
             *   domain must be registered and exist in
             *   both OpenSRS and the appropriate registry
             * handle: instructions for processing the order,
             *   overrides RSP's 'process immediately' setting
             *   values:
             *     - save = pend order for RSP's later
             *              approval
             *     - process = process order immediately
             * period: renewal period, from 1 to 10 years,
             *   may not exceed 10 years
             */
            "auto_renew" => "",
            "currentexpirationyear" => "",
            "domain" => "",
            "handle" => "",
            "period" => "",

            /**
             * Optional
             *
             * affiliate_id: ID that allows RSPs to track
             *   orders coming through various affiliates
             * f_parkp: enable Parked Pages Program. note
             *   enabling Parked Pages changes the nameservers
             *   of that domain. values:
             *     - Y = enable
             *     - N = do not enable
             *
             *   available for the following TLDs:
             *     .COM, .NET, .ORG, .INFO, .BIZ, .MOBI,
             *     .NAME, .ASIA, .BE, .BZ, .CA, .CC, .CO,
             *     .EU, .IN, .ME, .NL, .TV, .UK, .US,
             *     .WS, .XXX
             */
             "affiliate_id" => "",
             "f_parkp" => "",
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

        $data->data->auto_renew = "Y";
        $data->data->currentexpirationyear = date("Y");
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->handle = "save";
        $data->data->period = "1";

        $ns = new ProvisioningRenew( 'array', $data );

        $this->assertTrue( $ns instanceof ProvisioningRenew );
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

        $data->data->auto_renew = "Y";
        $data->data->currentexpirationyear = date("Y");
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->handle = "save";
        $data->data->period = "1";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no period sent
        unset( $data->data->period );
        $ns = new ProvisioningRenew( 'array', $data );



        // no handle sent
        unset( $data->data->handle );
        $ns = new ProvisioningRenew( 'array', $data );



        // no domain sent
        unset( $data->data->domain );
        $ns = new ProvisioningRenew( 'array', $data );



        // no currentexpirationyear sent
        unset( $data->data->currentexpirationyear );
        $ns = new ProvisioningRenew( 'array', $data );



        // no auto_renew sent
        unset( $data->data->auto_renew );
        $ns = new ProvisioningRenew( 'array', $data );
     }
}
