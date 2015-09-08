<?php

use OpenSRS\domains\provisioning\ProvisioningActivate;
/**
 * @group provisioning
 * @group ProvisioningActivate
 */
class ProvisioningActivateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provActivate';

    protected $validSubmission = array(
        "data" => array(
            "func" => "provActivate",

            /**
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: the .DE domain you want
             *   to activate, required only if
             *   cookie is not sent
             */
            "cookie" => "",
            // domainname in class, domain in API docs?
            // "domain" => "",
            "domainname" => "",
            )
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->cookie = md5(time());
        $data->data->domainname = "phptest" . time() . ".com";

        $ns = new ProvisioningActivate( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->cookie = md5(time());
        $data->data->domainname = "phptest" . time() . ".com";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no domainname sent
        unset( $data->data->domainname );
        $ns = new ProvisioningActivate( 'array', $data );



        // setting cookie and bypass in the
        // same request
        $data->data->bypass = $data->data->cookie;
        $ns = new ProvisioningActivate( 'array', $data );
        // removing bypass
        unset( $data->data->bypass );



        // no cookie sent
        unset( $data->data->cookie );
        $ns = new ProvisioningActivate( 'array', $data );
     }
}
