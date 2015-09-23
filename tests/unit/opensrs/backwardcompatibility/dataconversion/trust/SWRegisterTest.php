<?php

use opensrs\backwardcompatibility\dataconversion\trust\SWRegister;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group trust
 * @group BC_SWRegister
 */
class BC_SWRegisterTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'reg_type' => '',
            'product_type' => '',
            'special_instructions' => '',
            'seal_in_search' => '',
            'trust_seal' => '',
            'period' => '',
            'approver_email' => '',
            'domain' => '',
            'csr' => '',
            'server_count' => '',
            'handle' => '',
            ),

        'personal' => array(
            'first_name' => '',
            'last_name' => '',
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

        $data->data->reg_type = 'new';
        $data->data->product_type = 'domain';
        $data->data->special_instructions = 'no special instructions';
        $data->data->seal_in_search = '1';
        $data->data->trust_seal = '1';
        $data->data->period = '5';
        $data->data->approver_email = 'phptoolkit@tucows.com';
        $data->data->domain = 'phptest'.time().'.com';
        $data->data->csr = 'test';
        $data->data->server_count = '2';
        $data->data->handle = md5(time());

        $data->personal->first_name = 'Tikloot';
        $data->personal->last_name = 'Php';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->contact_set = new \stdClass();

        $shouldMatchNewDataObject->attributes->reg_type = $data->data->reg_type;
        $shouldMatchNewDataObject->attributes->product_type = $data->data->product_type;
        $shouldMatchNewDataObject->attributes->special_instructions = $data->data->special_instructions;
        $shouldMatchNewDataObject->attributes->seal_in_search = $data->data->seal_in_search;
        $shouldMatchNewDataObject->attributes->trust_seal = $data->data->trust_seal;
        $shouldMatchNewDataObject->attributes->period = $data->data->period;
        $shouldMatchNewDataObject->attributes->approver_email = $data->data->approver_email;
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->csr = $data->data->csr;
        $shouldMatchNewDataObject->attributes->server_count = $data->data->server_count;
        $shouldMatchNewDataObject->attributes->handle = $data->data->handle;

        $shouldMatchNewDataObject->attributes->contact_set->organization = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->admin = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->billing = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->tech = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->signer = $data->personal;

        $pc = new SWRegister();

        $newDataObject = $pc->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
