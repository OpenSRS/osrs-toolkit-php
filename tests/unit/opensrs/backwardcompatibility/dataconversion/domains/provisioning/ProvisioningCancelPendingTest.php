<?php

use opensrs\backwardcompatibility\dataconversion\domains\provisioning\ProvisioningCancelPending;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_ProvisioningCancelPending
 */
class BC_ProvisioningCancelPendingTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'status' => '',
            'to_date' => '',
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

        $data->data->status = 'declined';
        $data->data->to_date = time();

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->status = $data->data->status;
        $shouldMatchNewDataObject->attributes->to_date = $data->data->to_date;

        $ns = new ProvisioningCancelPending();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
