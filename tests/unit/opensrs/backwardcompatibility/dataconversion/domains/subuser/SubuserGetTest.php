<?php

use opensrs\backwardcompatibility\dataconversion\domains\subuser\SubuserGet;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group subuser
 * @group BC_SubuserGet
 */
class BC_SubuserGetTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'username' => '',

            'domain' => '',
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

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->cookie = $data->data->cookie;
        $shouldMatchNewDataObject->username = $data->data->username;

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;

        $ns = new SubuserGet();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
