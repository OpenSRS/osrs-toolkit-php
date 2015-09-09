<?php

use OpenSRS\domains\cookie\CookieDelete;

/**
 * @group cookie
 * @group CookieDelete
 */
class CookieDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $fund = "cookieDelete";

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * cookie: cookie to be deleted
             */
            "cookie" => "",
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
        $data->data->cookie = md5(time());

        $ns = new CookieDelete( 'array', $data );

        $this->assertTrue( $ns instanceof CookieDelete );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing cookie' => array('cookie'),
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

        $data->data->cookie = md5(time());

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

        $ns = new CookieDelete( 'array', $data );
    }
}
