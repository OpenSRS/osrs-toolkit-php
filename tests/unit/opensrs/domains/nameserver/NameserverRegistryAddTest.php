<?php

use OpenSRS\domains\nameserver\NameserverRegistryAdd;
/**
 * @group nameserver
 * @group NameserverRegistryAdd
 */
class NameserverRegistryAddTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'nsRegistryAdd';

    protected $validSubmission = array(
        "data" => array(
            "func" => "nsRegistryAdd",

            /**
             * Required
             *
             * all: specify whether to add nameserver
             *   to all registries or not
             *   0 = add only to registry specified
             *       in 'tld' parameter
             *   1 = add to all registries enabled
             *       on your account
             * fqdn: nameserver to be added, must
             *   be fully qualified domain name
             * tld: registry to which you want to add
             *   the nameserver, value can be any tld
             *   available through OpenSRS ie: .com
             *   * if 'all' is 1, 'tld' is ignored
             *     however it must be present and
             *     the value must be a valid tld,
             *     otherwise the command will fail
             */
            "all" => "",
            "fqdn" => "",
            "tld" => "",
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

        $data->data->all = "0";
        $data->data->fqdn = "ns1." . "phptest" . time() . ".com";
        $data->data->tld = ".com";

        $ns = new NameserverRegistryAdd( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->all = "0";
        $data->data->fqdn = "ns1." . "phptest" . time() . ".com";
        $data->data->tld = ".com";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no 'all' sent
        unset( $data->data->all );
        $ns = new NameserverRegistryAdd( 'array', $data );



        // no fqdn sent
        unset( $data->data->fqdn );
        $ns = new NameserverRegistryAdd( 'array', $data );



        // no tld sent
        unset( $data->data->tld );
        $ns = new NameserverRegistryAdd( 'array', $data );
    }
}
