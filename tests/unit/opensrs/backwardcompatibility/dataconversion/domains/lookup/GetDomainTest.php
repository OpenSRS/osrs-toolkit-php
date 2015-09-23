<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\GetDomain;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_GetDomain
 */
class BC_GetDomainTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'domain' => '',
            'registrant_ip' => '',
            'limit' => '',
            'domain_name' => '',
            'page' => '',
            'max_to_expiry' => '',
            'min_to_expiry' => '',
            'type' => '',
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
        $data->data->domain = 'phptest'.time().'.com';
        $data->data->domain_name = 'tsetphp'.time().'.com';

        $data->data->registrant_ip = long2ip(time());

        $data->data->max_to_expiry = strtotime('-1 week');
        $data->data->min_to_expiry = strtotime('-2 years');

        $data->data->page = '10';
        $data->data->limit = '100';
        $data->data->type = md5(serialize($data));

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->domain_name = $data->data->domain_name;

        $shouldMatchNewDataObject->attributes->registrant_ip = $data->data->registrant_ip;

        $shouldMatchNewDataObject->attributes->max_to_expiry = $data->data->max_to_expiry;
        $shouldMatchNewDataObject->attributes->min_to_expiry = $data->data->min_to_expiry;

        $shouldMatchNewDataObject->attributes->page = $data->data->page;
        $shouldMatchNewDataObject->attributes->limit = $data->data->limit;

        $shouldMatchNewDataObject->attributes->type = $data->data->type;

        $ns = new GetDomain();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
