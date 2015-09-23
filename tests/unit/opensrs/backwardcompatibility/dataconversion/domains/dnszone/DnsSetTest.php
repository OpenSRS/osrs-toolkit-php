<?php

use opensrs\backwardcompatibility\dataconversion\domains\dnszone\DnsSet;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group dnszone
 * @group BC_DnsSet
 */
class BC_DnsSetTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
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
        $data->data->dns_template = md5(time());
        $data->data->a = array(
            array(
                'hostname' => '@',
                'ip_address' => long2ip(time()),
                ),
            array(
                'hostname' => '@',
                'ip_address' => long2ip(time()),
                ),
            );
        $data->data->aaaa = array(
            array(
                'ipv6_address' => md5(time()),
                'subdomain' => 'ftp',
                ),
            array(
                'ipv6_address' => md5(time()),
                'subdomain' => 'www',
                ),
            );
        $data->data->cname = array(
            array(
                'hostname' => '@',
                'subdomain' => 'www',
                ),
            array(
                'hostname' => '@',
                'subdomain' => 'ftp',
                ),
            );
        $data->data->mx = array(
            array(
                'priority' => '10',
                'subdomain' => '@',
                'hostname' => 'mail.tucows.com',
                ),
            array(
                'priority' => '20',
                'subdomain' => '@',
                'hostname' => 'mail2.tucows.com',
                ),
            );
        $data->data->srv = array();
        $data->data->txt = array();

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->dns_template = $data->data->dns_template;
        $shouldMatchNewDataObject->attributes->A = $data->data->a;
        $shouldMatchNewDataObject->attributes->AAAA = $data->data->aaaa;
        $shouldMatchNewDataObject->attributes->CNAME = $data->data->cname;
        $shouldMatchNewDataObject->attributes->MX = $data->data->mx;
        $shouldMatchNewDataObject->attributes->SRV = $data->data->srv;
        $shouldMatchNewDataObject->attributes->TXT = $data->data->txt;

        $ns = new DnsSet();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
