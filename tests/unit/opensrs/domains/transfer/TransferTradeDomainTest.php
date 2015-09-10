<?php

use OpenSRS\domains\transfer\TransferTradeDomain;
/**
 * @group transfer
 * @group TransferTradeDomain
 */
class TransferTradeDomainTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferTradeDomain';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * domain: domain that is being traded
             * email: new owner's email address
             * first_name: new owner's first name
             * last_name: new owner's last name
             * org_name: name of the new owner's
             *   organization
             */
            "domain" => "",
            "email" => "",
            "first_name" => "",
            "last_name" => "",
            "org_name" => "",

            /**
             * Required for all except .BE domains
             *
             * address1: street address of new owner
             * city: new owner's city
             * country: new owner's country
             * phone: new owner's phone number
             * postal_code: new owner's postal code
             * state: new owner's state
             * tld_data: associative array containing
             *   any additional fields required by
             *   various domain registries
             */
            "address1" => "",
            "city" => "",
            "country" => "",
            "phone" => "",
            "postal_code" => "",
            "state" => "",
            "tld_data" => "",

            /**
             * Required only for .BE domains
             *
             * domain_auth_info: domain Authcode, to
             *   request an Authcode use send_authcode
             *   API call; Authcode is sent to domain's
             *   admin contact
             */
            "domain_auth_info" => "",
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

        $data->data->domain = "phptest" . time() . ".be";

        $data->data->email = "phptoolkit@tucows.com";
        $data->data->first_name = "Php";
        $data->data->last_name = "Toolkit";
        $data->data->org_name = "Tikloot Php";

        $ns = new TransferTradeDomain( 'array', $data );

        $this->assertTrue( $ns instanceof TransferTradeDomain );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing email' => array('email'),
            'missing first_name' => array('first_name'),
            'missing last_name' => array('last_name'),
            'missing org_name' => array('org_name'),
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

        $data->data->domain = "phptest" . time() . ".be";

        $data->data->email = "phptoolkit@tucows.com";
        $data->data->first_name = "Php";
        $data->data->last_name = "Toolkit";
        $data->data->org_name = "Tikloot Php";

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

        $ns = new TransferTradeDomain( 'array', $data );
    }
}
