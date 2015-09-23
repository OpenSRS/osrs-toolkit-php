<?php

use opensrs\backwardcompatibility\dataconversion\domains\provisioning\ProvisioningModify;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_ProvisioningModify
 */
class BC_ProvisioningModifyTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'affect_domains' => '',
            'data' => '',
            'domain' => '',
            'tld_data' => '',
            'display' => '',
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

        $data->data->cookie = md5(time());
        $data->data->affect_domains = '0';
        $data->data->data = 'ca_whois_display_setting';
        $data->data->domain = 'phptest'.time().'.ca';
        $data->data->tld_data = array();
        $data->data->display = 'PRIVATE';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->affect_domains = $data->data->affect_domains;
        $shouldMatchNewDataObject->attributes->data = $data->data->data;
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->tld_data = $data->data->tld_data;
        $shouldMatchNewDataObject->attributes->display = $data->data->display;

        $ns = new ProvisioningModify();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
