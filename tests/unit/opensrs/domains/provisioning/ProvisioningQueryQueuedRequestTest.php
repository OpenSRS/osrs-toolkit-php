<?php

use OpenSRS\domains\provisioning\ProvisioningQueryQueuedRequest;
/**
 * @group provisioning
 * @group ProvisioningQueryQueuedRequest
 */
class ProvisioningQueryQueuedRequestTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provProcessPending';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provProcessPending",

            /**
             * Required
             *
             * request_id: ID of the queued
             *   request; queue_request_id is
             *   returned when an order is
             *   queued
             */
            "request_id" => "",
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
        $data->data->request_id = time();
        $ns = new ProvisioningQueryQueuedRequest( 'array', $data );

        $this->assertTrue( $ns instanceof ProvisioningQueryQueuedRequest );
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

        $data->data->request_id = time();

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no request_id sent
        unset( $data->data->request_id );
        $ns = new ProvisioningQueryQueuedRequest( 'array', $data );
     }
}
