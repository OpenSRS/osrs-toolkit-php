<?php

use opensrs\backwardcompatibility\dataconversion\domains\authentication\AuthenticationSendPassword;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_AuthenticationSendPassword
 */
class BC_AuthenticationSendPasswordTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain_name' => '',
            'send_to' => '',
            'sub_user' => '',
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
        $data->data->domain_name = 'phptest'.time().'.com';
        $data->data->send_to = 'admin';
        $data->data->sub_user = '0';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain_name = $data->data->domain_name;
        $shouldMatchNewDataObject->attributes->send_to = $data->data->send_to;
        $shouldMatchNewDataObject->attributes->sub_user = $data->data->sub_user;

        $ns = new AuthenticationSendPassword();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
