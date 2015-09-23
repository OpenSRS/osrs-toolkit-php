<?php

use opensrs\backwardcompatibility\dataconversion\trust\QueryApproverList;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group trust
 * @group BC_QueryApproverList
 */
class BC_QueryApproverListTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'product_type' => '',
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

        $data->data->product_type = 'comodo_ev';
        $data->data->domain = 'google.com';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->product_type = $data->data->product_type;
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;

        $qal = new QueryApproverList();

        $newDataObject = $qal->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
