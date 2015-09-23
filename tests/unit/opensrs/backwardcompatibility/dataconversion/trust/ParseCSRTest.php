<?php

use opensrs\backwardcompatibility\dataconversion\trust\ParseCSR;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group trust 
 * @group BC_CancelOrder
 */
class BC_ParseCSR extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'product_type' => '',
            'csr' => '',
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

        $data->data->product_type = 'comodo_ev';
        $data->data->csr = rand();

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->product_type = $data->data->product_type;
        $shouldMatchNewDataObject->attributes->csr = $data->data->csr;

        $pc = new ParseCSR();

        $newDataObject = $pc->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
