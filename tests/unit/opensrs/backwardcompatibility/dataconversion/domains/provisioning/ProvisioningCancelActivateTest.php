<?php

use OpenSRS\backwardcompatibility\dataconversion\domains\provisioning\ProvisioningCancelActivate;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_ProvisioningCancelActivate
 */
class BC_ProvisioningCancelActivateTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        "data" => array(
            "domain" => "",
            "order_id" => "",
            ),
        );

    /**
     * Valid conversion should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validconversion
     */
    public function testValidDataConversion() {
        $data = json_decode( json_encode ($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->order_id = time();

        $shouldMatchNewDataObject = new \stdClass;
        $shouldMatchNewDataObject->attributes = new \stdClass;

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->order_id = $data->data->order_id;

        $ns = new ProvisioningCancelActivate();
        $newDataObject = $ns->convertDataObject( $data );

        $this->assertTrue( $newDataObject == $shouldMatchNewDataObject );
    }
}
