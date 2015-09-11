<?php

use OpenSRS\backwardcompatibility\dataconversion\domains\cookie\CookieQuit;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_CookieQuit
 */
class BC_CookieQuitTest extends PHPUnit_Framework_TestCase
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
        $shouldMatchNewDataObject->attributes = new \stdClass;

        $ns = new CookieQuit();
        $newDataObject = $ns->convertDataObject( $data );

        $this->assertTrue( $newDataObject == $shouldMatchNewDataObject );
    }
}
