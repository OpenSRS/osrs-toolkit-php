<?php

use opensrs\backwardcompatibility\dataconversion\domains\subuser\SubuserDelete;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group subuser
 * @group BC_SubuserDelete
 */
class BC_SubuserDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'username' => '',

            'domain' => '',
            'sub_id' => '',
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

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->cookie = $data->data->cookie;
        $shouldMatchNewDataObject->username = $data->data->username;

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->sub_id = $data->data->sub_id;

        $ns = new SubuserDelete();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
