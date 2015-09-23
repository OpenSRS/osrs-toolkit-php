<?php

use opensrs\backwardcompatibility\dataconversion\domains\transfer\TransferCheck;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_TransferCheck
 */
class BC_TransferCheckTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'check_status' => '',
            'get_request_address' => '',
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
        $data->data->check_status = '1';
        $data->data->get_request_address = '2';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->check_status = $data->data->check_status;
        $shouldMatchNewDataObject->attributes->get_request_address = $data->data->get_request_address;

        $ns = new TransferCheck();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
