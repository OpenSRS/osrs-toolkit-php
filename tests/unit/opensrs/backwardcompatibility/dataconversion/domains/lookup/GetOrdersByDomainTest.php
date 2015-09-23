<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\GetOrdersByDomain;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_GetOrdersByDomain
 */
class BC_GetOrdersByDomainTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'type' => '',
            'page' => '',
            'limit' => '',
            'order_to' => '',
            'status' => '',
            'order_from' => '',
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
        $data->data->type = 'test';
        $data->data->page = '10';
        $data->data->limit = '100';
        $data->data->status = time();
        $data->data->order_to = strtotime('+1 week');
        $data->data->order_from = strtotime('-1 year');

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->type = $data->data->type;
        $shouldMatchNewDataObject->attributes->page = $data->data->page;
        $shouldMatchNewDataObject->attributes->limit = $data->data->limit;
        $shouldMatchNewDataObject->attributes->status = $data->data->status;
        $shouldMatchNewDataObject->attributes->order_to = $data->data->order_to;
        $shouldMatchNewDataObject->attributes->order_from = $data->data->order_from;

        $ns = new GetOrdersByDomain();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
