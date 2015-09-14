<?php

use OpenSRS\backwardcompatibility\dataconversion\domains\authentication\AuthenticationCheckVersion;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_AuthenticationCheckVersion
 */
class BC_AuthenticationCheckVersionTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        "data" => array()
        );

    /**
     * Valid conversion should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validconversion
     */
    public function testValidDataConversion() {
        $data = json_decode( json_encode ($this->validSubmission) );

        $shouldMatchNewDataObject = new \stdClass;
        $shouldMatchNewDataObject->attributes = array();

        $ns = new AuthenticationCheckVersion();
        $newDataObject = $ns->convertDataObject( $data );

        $this->assertTrue( $newDataObject == $shouldMatchNewDataObject );
    }
}
