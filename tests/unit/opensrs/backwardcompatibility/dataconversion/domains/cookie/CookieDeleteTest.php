<?php

use opensrs\backwardcompatibility\dataconversion\domains\cookie\CookieDelete;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_CookieDelete
 */
class BC_CookieDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
//            "domain" => "",
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

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->cookie = $data->data->cookie;

        $ns = new CookieDelete();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
