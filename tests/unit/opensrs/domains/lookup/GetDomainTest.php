<?php

use OpenSRS\domains\lookup\GetDomain;
use OpenSRS\Request;
/**
 * @group lookup
 * @group GetDomain
 */
class GetDomainTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdCreate';

    protected $validSubmission = array(
        "attributes" => array(
            "domain" => "",
            "type" => "",
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

        $data->attributes->domain = 'phptest' . time() . '.com';
        $data->attributes->type = "all_info";
        $data->attributes->as_subreseller = 'katkinson';

        $ns = new GetDomain( 'array', $data );

        $this->assertTrue( $ns instanceof GetDomain );
    }

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidLiveSubmission() {
        $data = array(
            'func' => "lookupGetDomain",

            "attributes" => array(
                'domain' => 'phptest' . time() . '.com',
                'type' => 'all_info',
                ),
            );

        $request = new Request();
        $ns = $request->process('array', $data);

        $this->assertTrue( $ns instanceof GetDomain );
        $this->assertTrue( $ns->resultRaw['is_success'] == 1 );
    }
}
