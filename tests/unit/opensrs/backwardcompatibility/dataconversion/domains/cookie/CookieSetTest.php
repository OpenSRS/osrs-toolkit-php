<?php

use opensrs\backwardcompatibility\dataconversion\domains\cookie\CookieSet;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_CookieSet
 */
class BC_CookieSetTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
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

        $data->data->domain = 'phptest'.time().'.com';
        $data->data->reg_username = $data->data->domain;
        $data->data->reg_password = 'password1234';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->reg_username = $data->data->reg_username;
        $shouldMatchNewDataObject->attributes->reg_password = $data->data->reg_password;

        $ns = new CookieSet();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
