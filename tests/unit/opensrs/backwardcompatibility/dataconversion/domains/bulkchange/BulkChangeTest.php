<?php

use OpenSRS\backwardcompatibility\dataconversion\domains\bulkchange\BulkChange;
/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_BulkChange
 */
class BC_BulkChangeTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        "data" => array(
            "change_items" => "",
            "change_type" => "",
            "op_type" => "",
            "contact_email" => "",
            "apply_to_locked_domains" => "",
            )
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

        $data->data->change_items = "phptest.com,phptest2.com";
        $data->data->change_type = "dns_zone";
        $data->data->op_type = "move_to_storefront";
        $data->data->contact_email = "phptoolkit@tucows.com";
        $data->data->apply_to_locked_domains = "N";

        $data->personal = (object)array(
            "first_name" => "Tikloot",
            "last_name" => "Php",
            "country" => "canada",
            );

        $shouldMatchNewDataObject = new \stdClass;
        $shouldMatchNewDataObject->attributes = new \stdClass;

        $shouldMatchNewDataObject->attributes->change_type = $data->data->change_type;
        $shouldMatchNewDataObject->attributes->op_type = $data->data->op_type;
        $shouldMatchNewDataObject->attributes->contact_email = $data->data->contact_email;

        $shouldMatchNewDataObject->attributes->change_items = explode(
            ",", $data->data->change_items
            );

        $shouldMatchNewDataObject->attributes->apply_to_locked_domains = $data->data->apply_to_locked_domains;

        $ns = new BulkChange();
        $newDataObject = $ns->convertDataObject( $data );

        print_r($newDataObject);

        $this->assertTrue( $newDataObject == $shouldMatchNewDataObject );
    }
}
