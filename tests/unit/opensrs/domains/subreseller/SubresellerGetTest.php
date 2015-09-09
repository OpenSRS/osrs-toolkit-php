<?php

use OpenSRS\domains\subreseller\SubresellerGet;
/**
 * @group subreseller
 * @group SubresellerGet
 */
class SubresellerGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'subresGet';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * username: username for the sub-reseller
             */
            "username" => "",
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

        $data->data->username = "subreseller" . time();

        $ns = new SubresellerGet( 'array', $data );

        $this->assertTrue( $ns instanceof SubresellerGet );
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

        $data->data->username = "subreseller" . time();

        $this->setExpectedException( 'OpenSRS\Exception' );



        // not sending username or password
        unset( $data->data->username );
        $ns = new SubresellerGet( 'array', $data );
     }
}
