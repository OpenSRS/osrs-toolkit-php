<?php

use opensrs\backwardcompatibility\dataconversion\domains\bulkchange\BulkTransfer;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_BulkTransfer
 */
class BC_BulkTransferTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'reg_username' => '',
            'reg_domain' => '',
            'reg_password' => '',
            'domain_list' => '',
            'personal' => '',
            'affiliate_id' => '',
            'handle' => '',
            'registrant_ip' => '',
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

        $data->data->reg_username = 'phptest';
        $data->data->reg_domain = 'phptest'.time().'.com';
        $data->data->reg_password = 'password1234';
        $data->data->domain_list = 'phptest.com,phptest2.com';
        $data->data->affiliate_id = time();
        $data->data->handle = 'test';
        $data->data->registrant_ip = long2ip(time());

        $data->personal = (object) array(
            'first_name' => 'Tikloot',
            'last_name' => 'Php',
            'country' => 'canada',
            );

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->contact_set = new \stdClass();

        $shouldMatchNewDataObject->attributes->reg_username = $data->data->reg_username;
        $shouldMatchNewDataObject->attributes->reg_domain = $data->data->reg_domain;
        $shouldMatchNewDataObject->attributes->reg_password = $data->data->reg_password;

        $shouldMatchNewDataObject->attributes->domain_list = explode(
            ',', $data->data->domain_list
            );

        $shouldMatchNewDataObject->attributes->affiliate_id = $data->data->affiliate_id;
        $shouldMatchNewDataObject->attributes->handle = $data->data->handle;
        $shouldMatchNewDataObject->attributes->registrant_ip = $data->data->registrant_ip;

        $shouldMatchNewDataObject->attributes->contact_set->owner = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->admin = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->billing = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->tech = $data->personal;

        $ns = new BulkTransfer();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
