<?php

namespace OpenSRS\trust;

use OpenSRS\trust\ParseCSR;
/**
 * @group trust
 * @group trust\ParseCSR
 */
class ParseCSRTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'csr' => '',
            'product_type' => '',
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
        $data = json_decode( json_encode($this->validSubmission) );

        $data->attributes->csr = md5(time());
        $data->attributes->product_type = 'domain';


        $ns = new ParseCSR( 'array', $data );

        $this->assertTrue( $ns instanceof ParseCSR );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing csr' => array('csr'),
            'missing product_type' => array('product_type'),
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
        $data = json_decode( json_encode($this->validSubmission) );

        $data->attributes->csr = md5(time());
        $data->attributes->product_type = 'domain';

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

        $ns = new ParseCSR( 'array', $data );
    }
}
