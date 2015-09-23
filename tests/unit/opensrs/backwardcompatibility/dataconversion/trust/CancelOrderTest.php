<?php

use opensrs\backwardcompatibility\dataconversion\trust\CancelOrder;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group trust 
 * @group BC_CancelOrder
 */
class BC_CancelOrder extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
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

        $data->data->order_id = '123';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;

        $co = new CancelOrder();

        $newDataObject = $co->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
