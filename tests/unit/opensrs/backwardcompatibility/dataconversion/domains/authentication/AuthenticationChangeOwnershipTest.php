<?php

use opensrs\backwardcompatibility\dataconversion\domains\authentication\AuthenticationChangeOwnership;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_AuthenticationChangeOwnership
 */
class BC_AuthenticationChangeOwnershipTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'domain' => '',
            'username' => '',
            'password' => '',
            'move_all' => '',
            'reg_domain' => '',
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

        $data->data->cookie = md5(time());
        $data->data->domain = 'phptest'.time().'.com';
        $data->data->username = 'phptest'.time().'.com';
        $data->data->password = 'password1234';
        $data->data->move_all = '0';
        $data->data->reg_domain = '';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->cookie = $data->data->cookie;
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->username = $data->data->username;
        $shouldMatchNewDataObject->attributes->password = $data->data->password;
        $shouldMatchNewDataObject->attributes->move_all = $data->data->move_all;
        $shouldMatchNewDataObject->attributes->reg_domain = $data->data->reg_domain;

        $ns = new AuthenticationChangeOwnership();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
