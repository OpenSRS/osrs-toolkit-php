<?php

use opensrs\backwardcompatibility\dataconversion\domains\transfer\TransferGetIn;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_TransferGetIn
 */
class BC_TransferGetInTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'completed_from' => '',
            'completed_to' => '',
            'domain' => '',
            'limit' => '',
            'losing_registrar' => '',
            'order_id' => '',
            'order_from' => '',
            'owner_confirm_from' => '',
            'owner_confirm_ip' => '',
            'owner_confirm_to' => '',
            'owner_request_from' => '',
            'owner_request_to' => '',
            'page' => '',
            'request_address' => '',
            'status' => '',
            'transfer_id' => '',
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

        $data->data->completed_from = strtotime('-1 year');
        $data->data->completed_to = time();
        $data->data->domain = 'phptest'.time().'.com';
        $data->data->limit = '100';
        $data->data->losing_registrar = 'registrar2';
        $data->data->order_id = time();
        $data->data->order_from = strtotime('-2 years');
        $data->data->owner_confirm_from = strtotime('-18 months');
        $data->data->owner_confirm_ip = long2ip(time());
        $data->data->owner_confirm_to = strtotime('-1 week');
        $data->data->owner_request_from = strtotime('-1 months');
        $data->data->owner_request_to = strtotime('-1 day');
        $data->data->page = '10';
        $data->data->request_address = 'phptoolkit@tucows.com';
        $data->data->status = 'cancelled';
        $data->data->transfer_id = time();

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->completed_from = $data->data->completed_from;
        $shouldMatchNewDataObject->attributes->completed_to = $data->data->completed_to;
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->limit = $data->data->limit;
        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;
        $shouldMatchNewDataObject->attributes->order_from = $data->data->order_from;
        $shouldMatchNewDataObject->attributes->losing_registrar = $data->data->losing_registrar;
        $shouldMatchNewDataObject->attributes->owner_confirm_from = $data->data->owner_confirm_from;
        $shouldMatchNewDataObject->attributes->owner_confirm_to = $data->data->owner_confirm_to;
        $shouldMatchNewDataObject->attributes->owner_confirm_ip = $data->data->owner_confirm_ip;
        $shouldMatchNewDataObject->attributes->owner_request_from = $data->data->owner_request_from;
        $shouldMatchNewDataObject->attributes->owner_request_to = $data->data->owner_request_to;
        $shouldMatchNewDataObject->attributes->page = $data->data->page;
        $shouldMatchNewDataObject->attributes->request_address = $data->data->request_address;
        $shouldMatchNewDataObject->attributes->status = $data->data->status;
        $shouldMatchNewDataObject->attributes->transfer_id = $data->data->transfer_id;

        $ns = new TransferGetIn();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
