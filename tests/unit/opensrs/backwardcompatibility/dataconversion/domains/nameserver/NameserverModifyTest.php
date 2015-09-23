<?php

use opensrs\backwardcompatibility\dataconversion\domains\nameserver\NameserverModify;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_NameserverModify
 */
class BC_NameserverModifyTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'domain' => '',
            'ipaddress' => '',
            'ipv6' => '',
            'name' => '',
            'new_name' => '',

            // deprecated
            'new_encoding_type' => '',
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
        $data->data->new_name = 'new-'.$data->data->name;
        $data->data->new_encoding_type = 'UTF-8';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->ipaddress = $data->data->ipaddress;
        $shouldMatchNewDataObject->attributes->ipv6 = $data->data->ipv6;
        $shouldMatchNewDataObject->attributes->name = $data->data->name;
        $shouldMatchNewDataObject->attributes->new_name = $data->data->new_name;
        $shouldMatchNewDataObject->attributes->new_encoding_type = $data->data->new_encoding_type;

        $ns = new NameserverModify();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
