<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\GetOrderInfo;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_GetOrderInfo
 */
class BC_GetOrderInfoTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'page' => '',
            'limit' => '',
            'order_id' => '',
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

        $data->data->page = '10';
        $data->data->limit = '100';
        $data->data->order_id = time();
        $data->data->transfer_id = strtotime('+1 week');

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->page = $data->data->page;
        $shouldMatchNewDataObject->attributes->limit = $data->data->limit;
        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;
        $shouldMatchNewDataObject->attributes->transfer_id = $data->data->transfer_id;

        $ns = new GetOrderInfo();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
