<?php

use opensrs\backwardcompatibility\dataconversion\domains\transfer\TransferTradeDomain;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_TransferTradeDomain
 */
class BC_TransferTradeDomainTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'address1' => '',
            'city' => '',
            'country' => '',
            'domain' => '',
            'domain_auth_info' => '',
            'email' => '',
            'first_name' => '',
            'last_name' => '',
            'org_name' => '',
            'phone' => '',
            'postal_code' => '',
            'state' => '',
            'tld_data' => '',
            ),
        );

    /**
     * Valid conversion should complete with no
     * exception thrown.
     *
     *
     * @group validconversion
     */
    public function testValidDataConversion()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->data->domain = 'phptest'.time().'.com';

        $data->data->address1 = '123 Test Street';
        $data->data->city = 'Toronto';
        $data->data->country = 'Canada';

        $data->data->domain_auth_info = md5(time());
        $data->data->email = 'phptoolkit@tucows.com';
        $data->data->first_name = 'Tikloot';
        $data->data->last_name = 'Php';
        $data->data->org_name = 'Tucows';
        $data->data->phone = '234-555-1234';
        $data->data->postal_code = 'M1M1M1';
        $data->data->state = 'Ontario';
        $data->data->tld_data = array();

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->address1 = $data->data->address1;
        $shouldMatchNewDataObject->attributes->city = $data->data->city;
        $shouldMatchNewDataObject->attributes->country = $data->data->country;
        $shouldMatchNewDataObject->attributes->domain_auth_info = $data->data->domain_auth_info;
        $shouldMatchNewDataObject->attributes->email = $data->data->email;
        $shouldMatchNewDataObject->attributes->first_name = $data->data->first_name;
        $shouldMatchNewDataObject->attributes->last_name = $data->data->last_name;
        $shouldMatchNewDataObject->attributes->org_name = $data->data->org_name;
        $shouldMatchNewDataObject->attributes->phone = $data->data->phone;
        $shouldMatchNewDataObject->attributes->postal_code = $data->data->postal_code;
        $shouldMatchNewDataObject->attributes->state = $data->data->state;
        $shouldMatchNewDataObject->attributes->tld_data = $data->data->tld_data;

        $ns = new TransferTradeDomain();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
