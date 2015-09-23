<?php

namespace OpenSRS\trust;

use OpenSRS\trust\RequestOnDemandScan;
/**
 * @group trust
 * @group trust\RequestOnDemandScan
 */
class RequestOnDemandScanTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'order_id' => '',
            'product_id' => '',
            ),
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

        $data->attributes->order_id = time();
        $data->attributes->product_id = time();


        $ns = new RequestOnDemandScan( 'array', $data );

        $this->assertTrue( $ns instanceof RequestOnDemandScan );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = new \stdClass;
        $data->attributes = new \stdClass;

      $this->setExpectedExceptionRegExp(
          'OpenSRS\Exception',
          "/(order_id|product_id).*not defined/"
          );


        $ns = new RequestOnDemandScan( 'array', $data );
    }
}
