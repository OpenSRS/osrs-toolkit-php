<?php

use OpenSRS\domains\subreseller\SubresellerGet;
/**
 * @group subreseller
 * @group SubresellerGet
 */
class SubresellerGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subresGet';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * username: username for the sub-reseller
             */
            "username" => "",
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

        $data->data->username = "subreseller" . time();

        $ns = new SubresellerGet( 'array', $data );

        $this->assertTrue( $ns instanceof SubresellerGet );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing username' => array('username'),
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

        $data->data->username = "subreseller" . time();
        $data->data->amount = "10.00";

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

        $ns = new SubresellerGet( 'array', $data );
     }
}
