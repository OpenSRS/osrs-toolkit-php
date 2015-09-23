<?php

namespace OpenSRS\publishing;

use OpenSRS\publishing\GetControlPanelUrl;
/**
 * @group publishing
 * @group publishing\GetControlPanelUrl
 */
class GetControlPanelUrlTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'domain' => '',
            'service_type' => '',
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
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->attributes->domain = 'phptest' . time() . ".com";
        $data->attributes->service_type = "phptest" . time();

        $ns = new GetControlPanelUrl( 'array', $data );

        $this->assertTrue( $ns instanceof GetControlPanelUrl );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing service_type' => array('service_type'),
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
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'attributes', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->attributes->domain = 'phptest' . time() . ".com";
        $data->attributes->service_type = "test-service";
        
        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new GetControlPanelUrl( 'array', $data );
    }
}
