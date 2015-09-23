<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\GetDomainsByExpiry;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_GetDomainsByExpiry
 */
class BC_GetDomainsByExpiryTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'exp_from' => '',
            'exp_to' => '',
            'page' => '',
            'limit' => '',
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

        $data->data->exp_from = strtotime('-2 years');
        $data->data->exp_to = strtotime('-2 weeks');
        $data->data->page = '10';
        $data->data->limit = '100';

        $shouldMatchNewDataObject = new \stdClass();

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes->exp_from = $data->data->exp_from;
        $shouldMatchNewDataObject->attributes->exp_to = $data->data->exp_to;
        $shouldMatchNewDataObject->attributes->page = $data->data->page;
        $shouldMatchNewDataObject->attributes->limit = $data->data->limit;

        $ns = new GetDomainsByExpiry();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
