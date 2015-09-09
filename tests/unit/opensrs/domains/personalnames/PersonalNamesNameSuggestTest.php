<?php

use OpenSRS\domains\personalnames\PersonalNamesNameSuggest;
/**
 * @group personalnames
 * @group PersonalNamesNameSuggest
 */
class PersonalNamesNameSuggestTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persNameSuggest';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * searchstring: The name whose availability
             * you want to check, ie: 'john smith'.
             */
            "searchstring" => "",
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

        $data->data->searchstring = "john smith";

        $ns = new PersonalNamesNameSuggest( 'array', $data );

        $this->assertTrue( $ns instanceof PersonalNamesNameSuggest );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing searchstring' => array('searchstring'),
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

        $data->data->searchstring = "john smith";

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

        $ns = new PersonalNamesNameSuggest( 'array', $data );
    }
}
