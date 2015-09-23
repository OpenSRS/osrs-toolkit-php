<?php

use opensrs\backwardcompatibility\dataconversion\trust\UpdateProduct;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group trust
 * @group BC_UpdateProduct
 */
class BC_UpdateProductTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'product_id' => '',
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

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->product_id = $data->data->product_id;

        $pc = new UpdateProduct();

        $newDataObject = $pc->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
