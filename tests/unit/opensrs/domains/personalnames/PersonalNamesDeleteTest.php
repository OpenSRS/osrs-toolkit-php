<?php

use OpenSRS\domains\personalnames\PersonalNamesDelete;
/**
 * @group personalnames
 * @group PersonalNamesDelete
 */
class PersonalNamesDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persDelete';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * domain: perosnal names domain
             *   to be deleted
             */
            "domain" => ""
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

        $data->data->domain = "john.smith.net";

        $ns = new PersonalNamesDelete( 'array', $data );

        $this->assertTrue( $ns instanceof PersonalNamesDelete );
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
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "john.smith.net";

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

        $ns = new PersonalNamesDelete( 'array', $data );
    }
}
