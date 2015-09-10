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

        $this->assertTrue( $ns instanceof ProvisioningSendCIRAApproval );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
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

        $data->data->domain = "phptest" . time() . ".com";

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

        $ns = new ProvisioningSendCIRAApproval( 'array', $data );
     }
}
