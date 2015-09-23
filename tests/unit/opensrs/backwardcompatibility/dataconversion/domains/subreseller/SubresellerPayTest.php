<?php

use opensrs\backwardcompatibility\dataconversion\domains\subreseller\SubresellerPay;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group subreseller
 * @group BC_SubresellerPay
 */
class BC_SubresellerPayTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'username' => '',
            'amount' => '',
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

        $data->data->username = 'phptest'.time().'.com';
        $data->data->amount = '10';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->username = $data->data->username;
        $shouldMatchNewDataObject->attributes->amount = $data->data->amount;

        $ns = new SubresellerPay();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
