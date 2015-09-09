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
            /**
             * Required
             *
             * bypass: relevant domain, required
             *   only if cookie is not set
             * op_type: 'assign' when submitting
             *   assign_ns, 'add_remove' when
             *   submitting 'add_ns' or 'remove_ns'
             */
            "cookie" => "",
            "bypass" => "",
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
            "add_ns" => "",
            "assign_ns" => "",
            "remove_ns" => "",
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

        // assign_ns request
        $data->data->bypass = "phptest" . time() . ".com";
        $data->data->op_type = "assign";
        $data->data->assign_ns = "ns1." . $data->data->bypass . ";" .
                                 "ns2." . $data->data->bypass;

        $ns = new NameserverAdvancedUpdate( 'array', $data );

        $this->assertTrue( $ns instanceof NameserverAdvancedUpdate );



        // add_ns request
        $data->data->op_type = "add_remove";
        $data->data->add_ns = $data->data->assign_ns;

        // unset data we don't need for
        // this request
        unset($data->data->assign_ns);

        $ns = new NameserverAdvancedUpdate( 'array', $data );

        $this->assertTrue( $ns instanceof NameserverAdvancedUpdate );



        // remove_ns request
        $data->data->op_type = "add_remove";
        $data->data->remove_ns = $data->data->add_ns;

        // unset data we don't need for
        // this request
        unset($data->data->add_ns);

        $ns = new NameserverAdvancedUpdate( 'array', $data );

        $this->assertTrue( $ns instanceof NameserverAdvancedUpdate );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing bypass' => array('bypass'),
            'missing op_type' => array('op_type'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        // assign_ns request
        $data->data->bypass = "phptest" . time() . ".com";
        $data->data->op_type = "assign";
        $data->data->assign_ns = "ns1." . $data->data->bypass . ";" .
                                 "ns2." . $data->data->bypass;

        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new NameserverAdvancedUpdate( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsCookieAndBypassSent() {
        $data = json_decode( json_encode($this->validSubmission) );

        // assign_ns request
        $data->data->cookie = md5(time());
        $data->data->bypass = "phptest" . time() . ".com";
        $data->data->op_type = "assign";
        $data->data->assign_ns = "ns1." . $data->data->bypass . ";" .
                                 "ns2." . $data->data->bypass;

        $this->setExpectedExceptionRegExp(
          'OpenSRS\Exception',
        "/.*cookie.*bypass.*cannot.*one.*call.*/"
          );

        $ns = new NameserverAdvancedUpdate( 'array', $data );
    }
}
