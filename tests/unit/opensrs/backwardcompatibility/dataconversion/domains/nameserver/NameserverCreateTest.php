<?php

use opensrs\backwardcompatibility\dataconversion\domains\nameserver\NameserverCreate;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_NameserverCreate
 */
class BC_NameserverCreateTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'add_to_all_registry' => '',
            'domain' => '',
            'ipaddress' => '',
            'ipv6' => '',
            'name' => '',
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
        $data->data->cookie = md5(time());
        $data->data->add_to_all_registry = '.info,.name,.org,.biz,.de';
        $data->data->ipaddress = long2ip(time());
        $data->data->ipv6 = implode(':', str_split(sha1(dechex(mt_rand(0, 2147483647))), 4));
        $data->data->name = 'testname';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();

        // explode to an array since that's how
        // DataConversion is going to send this
        // one back
        $shouldMatchNewDataObject->attributes->add_to_all_registry = explode(
          ',',
          $data->data->add_to_all_registry
          );

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->ipaddress = $data->data->ipaddress;
        $shouldMatchNewDataObject->attributes->ipv6 = $data->data->ipv6;
        $shouldMatchNewDataObject->attributes->name = $data->data->name;

        $ns = new NameserverCreate();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
