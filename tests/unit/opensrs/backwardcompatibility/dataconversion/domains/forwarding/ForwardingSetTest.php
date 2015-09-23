<?php

use opensrs\backwardcompatibility\dataconversion\domains\forwarding\ForwardingSet;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_ForwardingSet
 */
class BC_ForwardingSetTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie',
            'domain' => '',
            'description',
            'destination_url',
            'enabled',
            'keywords',
            'subdomain',
            'title',
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
        $data->data->description = 'test description';
        $data->data->destination_url = 'http://new-phptest'.time().'.com';
        $data->data->enabled = '1';
        $data->data->keywords = 'keyword one two three';
        $data->data->masked = '0';
        $data->data->subdomain = 'forwarding.'.$data->data->domain;
        $data->data->title = 'test title';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;

        $shouldMatchNewDataObject->attributes->forwarding = array();
        $shouldMatchNewDataObject->attributes->forwarding[0] = new \stdClass();

        $shouldMatchNewDataObject->attributes->forwarding[0]->description =
            $data->data->description;
        $shouldMatchNewDataObject->attributes->forwarding[0]->destination_url =
            $data->data->destination_url;
        $shouldMatchNewDataObject->attributes->forwarding[0]->enabled =
            $data->data->enabled;
        $shouldMatchNewDataObject->attributes->forwarding[0]->keywords =
            $data->data->keywords;
        $shouldMatchNewDataObject->attributes->forwarding[0]->masked =
            $data->data->masked;
        $shouldMatchNewDataObject->attributes->forwarding[0]->subdomain =
            $data->data->subdomain;
        $shouldMatchNewDataObject->attributes->forwarding[0]->title =
            $data->data->title;

        $ns = new ForwardingSet();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
