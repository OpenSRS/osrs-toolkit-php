<?php

use OpenSRS\domains\provisioning\ProvisioningSendCIRAApproval;
/**
 * @group provisioning
 * @group ProvisioningSendCIRAApproval
 */
class ProvisioningSendCIRAApprovalTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provSendCIRAApproval';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provSendCIRAApproval",

            /**
             * Required
             *
             * domain: domain for which the CIRA
             *   approval email is to be sent
             */
            "domain" => "",
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



        // sending request with order_id only
        $data->data->domain = "phptest" . time() . ".com";
        $ns = new ProvisioningSendCIRAApproval( 'array', $data );
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

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no domain sent
        unset( $data->data->domain );
        $ns = new ProvisioningSendCIRAApproval( 'array', $data );
     }
}
