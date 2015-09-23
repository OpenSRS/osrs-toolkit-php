<?php

use opensrs\backwardcompatibility\dataconversion\domains\subuser\SubuserModify;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group subuser
 * @group BC_SubuserModify
 */
class BC_SubuserModifyTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'username' => '',

            'domain' => '',
            'sub_id' => '',
            'sub_username' => '',
            'sub_password' => '',
            'sub_permission' => '',
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
        $data->data->username = 'phptestuser';

        $data->data->domain = 'phptest'.time().'.com';
        $data->data->sub_id = time();
        $data->data->sub_username = 'subusername2';
        $data->data->sub_password = 'password1234';
        $data->data->sub_permission = '1';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->cookie = $data->data->cookie;
        $shouldMatchNewDataObject->username = $data->data->username;

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->sub_id = $data->data->sub_id;
        $shouldMatchNewDataObject->attributes->sub_username = $data->data->sub_username;
        $shouldMatchNewDataObject->attributes->sub_password = $data->data->sub_password;
        $shouldMatchNewDataObject->attributes->sub_permission = $data->data->sub_permission;

        $ns = new SubuserModify();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
