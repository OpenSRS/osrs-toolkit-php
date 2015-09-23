<?php

use opensrs\backwardcompatibility\dataconversion\trust\UpdateOrder;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group trust
 * @group BC_UpdateOrder
 */
class BC_UpdateOrderTest extends PHPUnit_Framework_TestCase
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

        $data->data->order_id = 'comodo_ev';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;

        $pc = new UpdateOrder();

        $newDataObject = $pc->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
