<?php

use opensrs\backwardcompatibility\dataconversion\domains\cookie\CookieUpdate;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_CookieUpdate
 */
class BC_CookieUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'domain_new' => '',

            'reg_username' => '',
            'reg_password' => '',
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
        $data->data->domain_new = 'new'.$data->data->domain;
        $data->data->reg_username = $data->data->domain;
        $data->data->reg_password = 'password1234';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->domain_new = $data->data->domain_new;
        $shouldMatchNewDataObject->attributes->reg_username = $data->data->reg_username;
        $shouldMatchNewDataObject->attributes->reg_password = $data->data->reg_password;

        $ns = new CookieUpdate();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
