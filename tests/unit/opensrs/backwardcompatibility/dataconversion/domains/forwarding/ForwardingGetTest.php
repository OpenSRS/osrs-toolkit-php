<?php

use opensrs\backwardcompatibility\dataconversion\domains\forwarding\ForwardingGet;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_ForwardingGet
 */
class BC_ForwardingGetTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
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

        $data->data->domain = 'phptest'.time().'.com';
        $data->data->cookie = md5(time());

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;

        $ns = new ForwardingGet();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
