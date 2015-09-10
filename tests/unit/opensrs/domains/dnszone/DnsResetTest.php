<?php

use OpenSRS\domains\dnszone\DnsReset;
/**
 * @group dnszone
 * @group DnsReset
 */
class DnsResetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'dnsReset';

    protected $validSubmission = array(
        'data' => array(
            /**
             * Required
             *
             * domain: the domain shose DNS you
             *   want to reset
             */
            'domain' => '',

            /**
             * Optional
             *
             * dns_template: name of the DNS
             *   template you want to use
             */
            'dns_template' => ''
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

        $data->data->domain = 'phptest'.time().'.com';

        $ns = new DnsReset( 'array', $data );

        $this->assertTrue( $ns instanceof DnsReset );
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

        $data->data->domain = 'phptest'.time().'.com';

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

        $ns = new DnsReset( 'array', $data );
    }
}
