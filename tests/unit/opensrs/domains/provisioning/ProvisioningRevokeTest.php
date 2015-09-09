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

        $this->assertTrue( $ns instanceof ProvisioningRevoke );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing reseller' => array('reseller'),
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
        $data->data->reseller = "reseller_username";

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

        $ns = new ProvisioningRevoke( 'array', $data );
     }
}
