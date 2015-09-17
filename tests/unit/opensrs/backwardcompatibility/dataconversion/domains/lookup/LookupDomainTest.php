<?php

use OpenSRS\backwardcompatibility\dataconversion\domains\lookup\LookupDomain;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_LookupDomain
 */
class BC_LookupDomainTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        "data" => array(
            'domain' => '',
            ),
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

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->maximum = "10";
        $data->selected = ".com;.net;.org";

        $shouldMatchNewDataObject = new \stdClass;
        $shouldMatchNewDataObject->attributes = new \stdClass;
        $shouldMatchNewDataObject->attributes->service_override = new \stdClass;
        $shouldMatchNewDataObject->attributes->service_override->lookup = new \stdClass;


        $shouldMatchNewDataObject->attributes->searchstring = $data->data->domain;
        $shouldMatchNewDataObject->attributes->services = array( 'lookup' );
        $shouldMatchNewDataObject->attributes->service_override->lookup->maximum = 
            $data->data->maximum;
        $shouldMatchNewDataObject->attributes->service_override->lookup->tlds = array(
            ".com", ".net", ".org"
            );

        $ns = new LookupDomain();

        $newDataObject = $ns->convertDataObject( $data );

        $this->assertTrue( $newDataObject == $shouldMatchNewDataObject );
    }
}
