<?php

use OpenSRS\domains\forwarding\ForwardingCreate;
/**
 * @group forwarding
 * @group ForwardingCreate
 */
class ForwardingCreateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdCreate';

    protected $validSubmission = array(
        "data" => array(
            "func" => "fwdCreate",

            /**
             * Optional
             *
             * domain: domain for which you want
             *   to enable forwarding
             */
            "domain" => ""
            )
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";

        $ns = new ForwardingCreate( 'array', $data );
    }
}
