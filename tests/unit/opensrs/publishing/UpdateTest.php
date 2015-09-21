<?php

namespace OpenSRS\publishing;

use OpenSRS\publishing\Update;
/**
 * @group publishing
 * @group publishing\Update
 */
class UpdateTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'service_type' => '',
            'source_domain' => '',
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

        $data->data->domain = 'phptest' . time() . ".com";
        $data->data->service_type = "phptest" . time();
        $data->data->source_domain = 'source.' . $data->data->domain;


        $ns = new Update( 'array', $data );

        $this->assertTrue( $ns instanceof Update );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing service_type' => array('service_type'),
            'missing source_domain' => array('source_domain'),
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
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->data->domain = 'phptest' . time() . ".com";
        $data->data->service_type = "phptest" . time();
        $data->data->source_domain = 'source.' . $data->data->domain;
        
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

        $ns = new Update( 'array', $data );
    }
}
