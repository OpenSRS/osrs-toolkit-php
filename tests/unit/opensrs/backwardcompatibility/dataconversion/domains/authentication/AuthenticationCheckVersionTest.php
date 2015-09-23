<?php

use opensrs\backwardcompatibility\dataconversion\domains\authentication\AuthenticationCheckVersion;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_AuthenticationCheckVersion
 */
class BC_AuthenticationCheckVersionTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(),
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

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = array();

        $ns = new AuthenticationCheckVersion();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
