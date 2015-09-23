<?php

use opensrs\backwardcompatibility\dataconversion\domains\authentication\AuthenticationSendAuthCode;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group authentication
 * @group BC_AuthenticationSendAuthCode
 */
class BC_AuthenticationSendAuthCodeTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
                'domain_name' => '',
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
        $data->data->domain_name = 'phptest'.time().'.com';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain_name = $data->data->domain_name;

        $ns = new AuthenticationSendAuthCode();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
