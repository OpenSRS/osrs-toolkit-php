<?php

use opensrs\backwardcompatibility\dataconversion\domains\transfer\TransferGetAway;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_TransferGetAway
 */
class BC_TransferGetAwayTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'gaining_registrar' => '',
            'limit' => '',
            'owner_confirm_from' => '',
            'owner_confirm_to' => '',
            'owner_request_from' => '',
            'owner_request_to' => '',
            'page' => '',
            'req_from' => '',
            'req_to' => '',
            'request_address' => '',
            'status' => '',
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
        $data->data->gaining_registrar = 'testregistrar';
        $data->data->limit = '10';
        $data->data->owner_confirm_from = strtotime('-1 month');
        $data->data->owner_confirm_to = time();
        $data->data->owner_request_from = strtotime('-2 months');
        $data->data->owner_request_to = strtotime('-1 week');
        $data->data->page = '5';
        $data->data->req_from = strtotime('-1 day');
        $data->data->req_to = strtotime('-1 hour');
        $data->data->request_address = 'phptoolkit@tucows.com';
        $data->data->status = 'cancelled';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->gaining_registrar = $data->data->gaining_registrar;
        $shouldMatchNewDataObject->attributes->limit = $data->data->limit;
        $shouldMatchNewDataObject->attributes->owner_confirm_from = $data->data->owner_confirm_from;
        $shouldMatchNewDataObject->attributes->owner_confirm_to = $data->data->owner_confirm_to;
        $shouldMatchNewDataObject->attributes->owner_request_from = $data->data->owner_request_from;
        $shouldMatchNewDataObject->attributes->owner_request_to = $data->data->owner_request_to;
        $shouldMatchNewDataObject->attributes->page = $data->data->page;
        $shouldMatchNewDataObject->attributes->req_from = $data->data->req_from;
        $shouldMatchNewDataObject->attributes->req_to = $data->data->req_to;
        $shouldMatchNewDataObject->attributes->request_address = $data->data->request_address;
        $shouldMatchNewDataObject->attributes->status = $data->data->status;

        $ns = new TransferGetAway();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
