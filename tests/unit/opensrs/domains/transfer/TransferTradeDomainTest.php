<?php

use opensrs\domains\transfer\TransferTradeDomain;

/**
 * @group transfer
 * @group TransferTradeDomain
 */
class TransferTradeDomainTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferTradeDomain';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain: domain that is being traded
             * email: new owner's email address
             * first_name: new owner's first name
             * last_name: new owner's last name
             * org_name: name of the new owner's
             *   organization
             */
            'domain' => '',
            'email' => '',
            'first_name' => '',
            'last_name' => '',
            'org_name' => '',

            /*
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
            'address1' => '',
            'city' => '',
            'country' => '',
            'phone' => '',
            'postal_code' => '',
            'state' => '',
            'tld_data' => '',

            /*
             * Required only for .BE domains
             *
             * domain_auth_info: domain Authcode, to
             *   request an Authcode use send_authcode
             *   API call; Authcode is sent to domain's
             *   admin contact
             */
            'domain_auth_info' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.be';

        $data->attributes->email = 'phptoolkit@tucows.com';
        $data->attributes->first_name = 'Php';
        $data->attributes->last_name = 'Toolkit';
        $data->attributes->org_name = 'Tikloot Php';

        $ns = new TransferTradeDomain('array', $data);

        $this->assertTrue($ns instanceof TransferTradeDomain);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
            'missing email' => array('email'),
            'missing first_name' => array('first_name'),
            'missing last_name' => array('last_name'),
            'missing org_name' => array('org_name'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.be';

        $data->attributes->email = 'phptoolkit@tucows.com';
        $data->attributes->first_name = 'Php';
        $data->attributes->last_name = 'Toolkit';
        $data->attributes->org_name = 'Tikloot Php';

        if (is_null($message)) {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$field.*not defined/"
              );
        } else {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$message/"
              );
        }

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new TransferTradeDomain('array', $data);
    }
}
