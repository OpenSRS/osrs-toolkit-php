<?php

use opensrs\backwardcompatibility\dataconversion\publishing\Update;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group publishing
 * @group BC_PublishingUpdate
 */
class BC_UpdateTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'service_type' => '',
            'end_user_auth_info' => '',
            'source_domain' => '',
            ),
        );

    /**
     * Valid conversion should complete with no
     * exception thrown.
     *
     *
     * @group validconversion
     */
    public function testValidDataConversion()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->data->domain = 'phptest'.time().'.com';
        $data->data->service_type = 'test-service';
        $data->data->end_user_auth_info = 'test-auth-info';
        $data->data->source_domain = 'source-'.$data->data->domain;

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->service_type = $data->data->service_type;
        $shouldMatchNewDataObject->attributes->end_user_auth_info = $data->data->end_user_auth_info;
        $shouldMatchNewDataObject->attributes->source_domain = $data->data->source_domain;

        $ns = new Update();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
