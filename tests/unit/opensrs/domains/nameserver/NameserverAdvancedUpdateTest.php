<?php

use OpenSRS\domains\nameserver\NameserverAdvancedUpdate;
/**
 * @group nameserver
 * @group NameserverAdvancedUpdate
 */
class NameserverAdvancedUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'nsAdvancedUpdt';
    
    protected $validSubmission = array(
        "data" => array(
            "func" => "nsAdvancedUpdt",

            /**
             * Required
             *
             * domain: relevant domain, required
             *   only if cookie is not set
             * op_type: 'assign' when submitting
             *   assign_ns, 'add_remove' when
             *   submitting 'add_ns' or 'remove_ns'
             */
            "cookie" => "",
            "domain" => "",
            "op_type" => "",

            /**
             * Optional
             *
             * add_ns: list of nameservers to add
             *   * cannot be submitted in the same
             *     request as assign_ns
             * assign_ns: list of nameservers to assign
             *   * cannot be submitted in same request
             *     as add_ns or remove_ns
             * remove_ns: list of nameservers to remove
             *   * cannot be submitted in same request
             *     as assign_ns
             */
            "add_ns" => "password12345",
            "assign_ns" => "password12345",
            "remove_ns" => "password12345",
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

        // assign_ns request
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->op_type = "assign";
        $data->data->assign_ns = "ns1." . $data->data->domain . ";ns2." . $data->data->domain;

        $ns = new NameserverAdvancedUpdate( 'array', $data );



        // add_ns request
        $data->data->cookie = md5(time());
        $data->data->op_type = "add_remove";
        $data->data->add_ns = $data->data->assign_ns;

        // unset data we don't need for
        // this request
        unset($data->data->assign_ns);

        $ns = new NameserverAdvancedUpdate( 'array', $data );



        // remove_ns request
        $data->data->cookie = md5(time());
        $data->data->op_type = "add_remove";
        $data->data->remove_ns = $data->data->add_ns;

        // unset data we don't need for
        // this request
        unset($data->data->add_ns);

        $ns = new NameserverAdvancedUpdate( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );
        $data->data->cookie = md5(time());
        $data->data->domain = "phptest" . time() . ".com";
        $data->data->op_type = "assign";
        $data->data->assign_ns = "ns1." . $data->data->domain . ";ns2." . $data->data->domain;

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no op_type sent
        unset( $data->data->op_type );
        $ns = new NameserverAdvancedUpdate( 'array', $data );



        // setting cookie and bypass in the
        // same request
        $data->data->bypass = $data->data->cookie;
        $ns = new NameserverAdvancedUpdate( 'array', $data );
        unset( $data->data->bypass );


        // no cookie sent
        unset( $data->data->cookie );
        $ns = new NameserverAdvancedUpdate( 'array', $data );
    }
}
