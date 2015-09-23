<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\AllInOneDomain;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_AllInOneDomain
 */
class BC_AllInOneDomainTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'searchstring' => '',
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

        $shouldMatchNewDataObject = new \stdClass();

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->searchstring = $data->data->domain;

        $shouldMatchNewDataObject->attributes->service_override = new \stdClass();
        $service_override = new \stdClass();

        $service_override->tlds = array('.com', '.net', '.org');

        $shouldMatchNewDataObject->attributes->service_override->lookup = $service_override;
        $shouldMatchNewDataObject->attributes->service_override->premium = $service_override;
        $shouldMatchNewDataObject->attributes->service_override->suggestion = $service_override;

        $shouldMatchNewDataObject->attributes->services = array(
            'lookup', 'premium', 'suggestion',
            );

        $ns = new AllInOneDomain();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
