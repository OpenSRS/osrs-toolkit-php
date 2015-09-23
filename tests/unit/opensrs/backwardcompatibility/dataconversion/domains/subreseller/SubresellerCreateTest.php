<?php

use opensrs\backwardcompatibility\dataconversion\domains\subreseller\SubresellerCreate;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group subreseller
 * @group BC_SubresellerCreate
 */
class BC_SubresellerCreateTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'ccp_enabled' => '',
            'low_balance_email' => '',
            'nameservers' => '',
            'password' => '',
            'payment_email' => '',
            'pricing_plan' => '',
            'status' => '',
            'system_status_email' => '',
            'url' => '',
            'username' => '',
            ),

        'personal' => array(
            'first_name' => '',
            'last_name' => '',
            ),
        'admin' => array(
            'first_name' => '',
            'last_name' => '',
            ),
        'billing' => array(
            'first_name' => '',
            'last_name' => '',
            ),
        'tech' => array(
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

        $data->data->ccp_enabled = 'Y';
        $data->data->low_balance_email = 'phptoolkit@tucows.com';
        $data->data->nameservers = 'ns1.phptest'.time().'.com';
        $data->data->password = 'password1234';
        $data->data->payment_email = 'phptoolkit@tucows.com';
        $data->data->pricing_plan = '1';
        $data->data->status = 'cancelled';
        $data->data->system_status_email = 'phptoolkit@tucows.com';
        $data->data->url = 'password1234';
        $data->data->username = 'phptest1234';

        $data->personal->first_name = 'Tikloot';
        $data->personal->last_name = 'Php';
        $data->admin->first_name = 'Tikloot';
        $data->admin->last_name = 'Php';
        $data->billing->first_name = 'Tikloot';
        $data->billing->last_name = 'Php';
        $data->tech->first_name = 'Tikloot';
        $data->tech->last_name = 'Php';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->contact_set = new \stdClass();

        $shouldMatchNewDataObject->attributes->ccp_enabled = $data->data->ccp_enabled;
        $shouldMatchNewDataObject->attributes->low_balance_email = $data->data->low_balance_email;
        $shouldMatchNewDataObject->attributes->nameservers = $data->data->nameservers;
        $shouldMatchNewDataObject->attributes->password = $data->data->password;
        $shouldMatchNewDataObject->attributes->payment_email = $data->data->payment_email;
        $shouldMatchNewDataObject->attributes->pricing_plan = $data->data->pricing_plan;
        $shouldMatchNewDataObject->attributes->status = $data->data->status;
        $shouldMatchNewDataObject->attributes->system_status_email = $data->data->system_status_email;
        $shouldMatchNewDataObject->attributes->url = $data->data->url;
        $shouldMatchNewDataObject->attributes->username = $data->data->username;
        $shouldMatchNewDataObject->attributes->contact_set->owner = $data->personal;
        $shouldMatchNewDataObject->attributes->contact_set->admin = $data->admin;
        $shouldMatchNewDataObject->attributes->contact_set->billing = $data->billing;
        $shouldMatchNewDataObject->attributes->contact_set->tech = $data->tech;

        $ns = new SubresellerCreate();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
