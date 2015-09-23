<?php

use opensrs\backwardcompatibility\dataconversion\domains\subreseller\SubresellerGet;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group subreseller
 * @group BC_SubresellerGet
 */
class BC_SubresellerGetTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'username' => '',
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

        $data->data->username = 'phptest'.time().'.com';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->username = $data->data->username;

        $ns = new SubresellerGet();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
