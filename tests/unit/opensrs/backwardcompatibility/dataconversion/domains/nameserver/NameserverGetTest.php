<?php

use opensrs\backwardcompatibility\dataconversion\domains\nameserver\NameserverGet;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_NameserverGet
 */
class BC_NameserverGetTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'domain' => '',
            'name' => '',
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
        $data->data->cookie = md5(time());
        $data->data->name = 'testname';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->name = $data->data->name;

        $ns = new NameserverGet();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
