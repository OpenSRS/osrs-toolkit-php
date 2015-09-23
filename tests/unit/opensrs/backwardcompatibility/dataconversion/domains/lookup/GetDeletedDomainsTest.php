<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\GetDeletedDomains;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_GetDeletedDomains
 */
class BC_GetDeletedDomainsTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'owner_email' => '',
            'admin_email' => '',
            'billing_email' => '',
            'tech_email' => '',
            'del_from' => '',
            'del_to' => '',
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

        $data->data->owner_email = 'phptoolkit@tucows.com';
        $data->data->admin_email = 'phptoolkit@tucows.com';
        $data->data->billing_email = 'phptoolkit@tucows.com';
        $data->data->billing_email = 'phptoolkit@tucows.com';

        $data->data->del_from = strtotime('-1 year');
        $data->data->del_to = strtotime('-1 week');
        $data->data->exp_from = strtotime('-2 years');
        $data->data->exp_to = strtotime('-2 weeks');
        $data->data->page = '10';
        $data->data->limit = '100';

        $shouldMatchNewDataObject = new \stdClass();

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->owner_email = $data->data->owner_email;
        $shouldMatchNewDataObject->attributes->admin_email = $data->data->admin_email;
        $shouldMatchNewDataObject->attributes->billing_email = $data->data->billing_email;
        $shouldMatchNewDataObject->attributes->billing_email = $data->data->billing_email;

        $shouldMatchNewDataObject->attributes->del_from = $data->data->del_from;
        $shouldMatchNewDataObject->attributes->del_to = $data->data->del_to;
        $shouldMatchNewDataObject->attributes->exp_from = $data->data->exp_from;
        $shouldMatchNewDataObject->attributes->exp_to = $data->data->exp_to;
        $shouldMatchNewDataObject->attributes->page = $data->data->page;
        $shouldMatchNewDataObject->attributes->limit = $data->data->limit;

        $ns = new GetDeletedDomains();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
