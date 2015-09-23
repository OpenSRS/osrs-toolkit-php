<?php

use opensrs\backwardcompatibility\dataconversion\domains\provisioning\ProvisioningProcessPending;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_ProvisioningProcessPending
 */
class BC_ProvisioningProcessPendingTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'command' => '',
            'fax_received' => '',
            'order_id' => '',
            'owner_address' => '',
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

        $data->data->command = 'cancel';
        $data->data->fax_received = '1';
        $data->data->order_id = time();
        $data->data->owner_address = 'phptoolkit@tucows.com';

        $shouldMatchNewDataObject = new \stdClass();

        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->command = $data->data->command;
        $shouldMatchNewDataObject->attributes->fax_received = $data->data->fax_received;
        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;
        $shouldMatchNewDataObject->attributes->owner_address = $data->data->owner_address;

        $ns = new ProvisioningProcessPending();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
