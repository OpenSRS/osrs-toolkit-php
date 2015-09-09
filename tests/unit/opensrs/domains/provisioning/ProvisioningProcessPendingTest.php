<?php

use OpenSRS\domains\provisioning\ProvisioningProcessPending;
/**
 * @group provisioning
 * @group ProvisioningProcessPending
 */
class ProvisioningProcessPendingTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provProcessPending';

    protected $validSubmission = array(
        "data" => array(
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
        $ns = new ProvisioningProcessPending( 'array', $data );

        $this->assertTrue( $ns instanceof ProvisioningProcessPending );


        // // sending request with domain only -- CLASS NOT SET UP TO ACCEPT THIS AS VALID
        // $data->data->domain = "phptest" . time() . ".com";
        // $ns = new ProvisioningProcessPending( 'array', $data );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing order_id' => array('order_id'),
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
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data' ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->order_id = time();

        $this->setExpectedExceptionRegExp(
            'OpenSRS\Exception',
            "/$field.*not defined/"
            );



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new ProvisioningProcessPending( 'array', $data );
     }
}
