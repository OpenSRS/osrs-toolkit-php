<?php

use opensrs\backwardcompatibility\dataconversion\domains\transfer\TransferProcess;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_TransferProcess
 */
class BC_TransferProcessTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
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

        $data->data->order_id = time();
        $data->data->reseller = 'reseller2';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;
        $shouldMatchNewDataObject->attributes->reseller = $data->data->reseller;

        $ns = new TransferProcess();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
