<?php

use opensrs\backwardcompatibility\dataconversion\domains\transfer\TransferRsp2Rsp;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_TransferRsp2Rsp
 */
class BC_TransferRsp2RspTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'grsp' => '',
            'username' => '',
            'password' => '',
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
        $data->data->grsp = 'grsp';
        $data->data->username = 'reseller2';
        $data->data->password = 'password1234';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->grsp = $data->data->grsp;
        $shouldMatchNewDataObject->attributes->username = $data->data->username;
        $shouldMatchNewDataObject->attributes->password = $data->data->password;

        $ns = new TransferRsp2Rsp();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
