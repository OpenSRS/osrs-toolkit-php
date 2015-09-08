<?php

use OpenSRS\domains\provisioning\ProvisioningCancelActivate;
/**
 * @group provisioning
 * @group ProvisioningCancelActivate
 */
class ProvisioningCancelActivateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provCancelActivate';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provCancelActivate",

            /**
             * Required: 1 of 2
             *
             * order_id: cookie to be deleted
             * domain: the .CA domain you want
             *   to cancel activation for
             */
            "order_id" => "",
            // class not set up to accept
            // cancel based on domain only
            // // "domain" => "",
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
        $data->data->order_id = time();
        $ns = new ProvisioningCancelActivate( 'array', $data );
        unset( $data->data->order_id );


        // // sending request with domain only -- CLASS NOT SET UP TO ACCEPT THIS AS VALID
        // $data->data->domain = "phptest" . time() . ".com";
        // $ns = new ProvisioningCancelActivate( 'array', $data );
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

        $data->data->order_id = time();
        // $data->data->domain = "phptest" . time() . ".com";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // // no domain sent -- CLASS NOT SET UP TO ACCEPT THIS AS VALID
        // unset( $data->data->domain );
        // $ns = new ProvisioningCancelActivate( 'array', $data );



        // no cookie sent
        unset( $data->data->order_id );
        $ns = new ProvisioningCancelActivate( 'array', $data );
     }
}
