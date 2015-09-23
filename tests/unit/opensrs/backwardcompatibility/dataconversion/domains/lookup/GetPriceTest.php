<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\GetPrice;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_GetPrice
 */
class BC_GetPriceTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'period' => '',
            'reg_type' => '',
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
        $data->data->period = strtotime('+1 week');
        $data->data->reg_type = strtotime('-1 year');

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->period = $data->data->period;
        $shouldMatchNewDataObject->attributes->reg_type = $data->data->reg_type;

        $ns = new GetPrice();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
