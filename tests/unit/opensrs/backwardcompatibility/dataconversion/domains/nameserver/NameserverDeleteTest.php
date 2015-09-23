<?php

use opensrs\backwardcompatibility\dataconversion\domains\nameserver\NameserverDelete;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_NameserverDelete
 */
class BC_NameserverDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
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
        $data->data->ipaddress = long2ip(time());
        $data->data->ipv6 = implode(':', str_split(sha1(dechex(mt_rand(0, 2147483647))), 4));
        $data->data->name = 'testname';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->ipaddress = $data->data->ipaddress;
        $shouldMatchNewDataObject->attributes->ipv6 = $data->data->ipv6;
        $shouldMatchNewDataObject->attributes->name = $data->data->name;

        $ns = new NameserverDelete();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
