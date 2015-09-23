<?php

use opensrs\backwardcompatibility\dataconversion\trust\RequestOnDemandScan;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group trust
 * @group BC_RequestOnDemandScan
 */
class BC_RequestOnDemandScan extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'product_id' => '',
            'order_id' => '',
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

        $data->data->product_id = '123';
        $data->data->order_id = '456';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->product_id = $data->data->product_id;
        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;

        $rods = new RequestOnDemandScan();

        $newDataObject = $rods->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
