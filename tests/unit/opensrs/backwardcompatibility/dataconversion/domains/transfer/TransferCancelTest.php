<?php

use opensrs\backwardcompatibility\dataconversion\domains\transfer\TransferCancel;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_TransferCancel
 */
class BC_TransferCancelTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'order_id' => '',
            'reseller' => '',
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
        $data->data->order_id = time();
        $data->data->reseller = 'reseller1';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;
        $shouldMatchNewDataObject->attributes->reseller = $data->data->reseller;

        $ns = new TransferCancel();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
