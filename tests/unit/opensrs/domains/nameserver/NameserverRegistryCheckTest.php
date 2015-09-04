<?php

use OpenSRS\domains\nameserver\NameserverRegistryCheck;
/**
 * @group nameserver
 * @group NameserverRegistryCheck
 */
class NameserverRegistryCheckTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'nsRegistryAdd';

    protected $validSubmission = array(
        "data" => array(
            "func" => "nsRegistryAdd",

            /**
             * Required
             *
             * fqdn: nameserver to be checked, must
             *   be fully qualified domain name
             * tld: TLD of the nameserver you want
             *   to check
             *   * if not supplied, the tld is
             *     extracted from the 'fqdn' field
             */
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

        $data->data->fqdn = "ns1." . "phptest" . time() . ".com";
        $data->data->tld = ".com";

        $ns = new NameserverRegistryCheck( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->fqdn = "ns1." . "phptest" . time() . ".com";
        $data->data->tld = ".com";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no fqdn sent
        unset( $data->data->fqdn );
        $ns = new NameserverRegistryCheck( 'array', $data );



        // no tld sent
        unset( $data->data->tld );
        $ns = new NameserverRegistryCheck( 'array', $data );
    }
}
